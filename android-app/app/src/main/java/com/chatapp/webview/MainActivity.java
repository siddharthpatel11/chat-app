package com.chatapp.webview;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.text.InputType;
import android.view.GestureDetector;
import android.view.KeyEvent;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.webkit.ConsoleMessage;
import android.webkit.GeolocationPermissions;
import android.webkit.JavascriptInterface;
import android.webkit.PermissionRequest;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebResourceError;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.core.content.FileProvider;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Locale;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import com.google.android.gms.auth.GoogleAuthUtil;
import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInClient;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.common.api.ApiException;
import com.google.android.gms.common.api.Scope;
import com.google.android.gms.tasks.Task;

public class MainActivity extends AppCompatActivity {

    // ─── Prefs keys ───────────────────────────────────────────────────────────
    private static final String PREFS_NAME = "ChatAppPrefs";
    private static final String PREF_SERVER_URL = "server_url";

    // Default URL — user can change this from inside the app without rebuilding
    private static final String DEFAULT_URL = "https://YOUR-NGROK-URL.ngrok-free.app/chat";

    private static final int REQUEST_PERMISSIONS = 100;
    private static final int REQUEST_SELECT_FILE = 200;
    private static final int RC_SIGN_IN = 300;

    private ExecutorService executorService = Executors.newSingleThreadExecutor();

    private WebView webView;
    private SwipeRefreshLayout swipeRefreshLayout;
    private ProgressBar progressBar;
    private LinearLayout errorLayout;
    private TextView errorText;

    private ValueCallback<Uri[]> filePathCallback;
    private Uri cameraPhotoUri;

    private GestureDetector gestureDetector;

    // ─── Get / set saved URL ──────────────────────────────────────────────────

    private String getSavedUrl() {
        SharedPreferences prefs = getSharedPreferences(PREFS_NAME, MODE_PRIVATE);
        return prefs.getString(PREF_SERVER_URL, null);
    }

    private void saveUrl(String url) {
        getSharedPreferences(PREFS_NAME, MODE_PRIVATE)
            .edit()
            .putString(PREF_SERVER_URL, url)
            .apply();
    }

    private String getAppUrl() {
        String saved = getSavedUrl();
        return (saved != null && !saved.isEmpty()) ? saved : DEFAULT_URL;
    }

    // ─── Lifecycle ────────────────────────────────────────────────────────────

    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Full-screen / edge-to-edge
        getWindow().setStatusBarColor(Color.parseColor("#202c33"));
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);

        setContentView(R.layout.activity_main);

        webView          = findViewById(R.id.webview);
        swipeRefreshLayout = findViewById(R.id.swipe_refresh);
        progressBar      = findViewById(R.id.progress_bar);
        errorLayout      = findViewById(R.id.error_layout);
        errorText        = findViewById(R.id.error_text);

        setupWebView();
        requestAllPermissions();

        swipeRefreshLayout.setColorSchemeColors(Color.parseColor("#00a884"));
        swipeRefreshLayout.setProgressBackgroundColorSchemeColor(Color.parseColor("#202c33"));
        swipeRefreshLayout.setOnRefreshListener(() -> webView.reload());

        // Long-press anywhere on the progress bar area launches the URL-settings dialog
        // (Useful when the page fails to load and you need to change the ngrok URL)
        errorLayout.setOnLongClickListener(v -> {
            showUrlSettingsDialog();
            return true;
        });

        // Detect long-press on the WebView → open URL settings
        gestureDetector = new GestureDetector(this, new GestureDetector.SimpleOnGestureListener() {
            @Override
            public void onLongPress(MotionEvent e) {
                showUrlSettingsDialog();
            }
        });
        webView.setOnTouchListener((v, event) -> {
            gestureDetector.onTouchEvent(event);
            return false; // let WebView handle the event too
        });

        // First launch or URL not configured → show setup dialog
        if (getSavedUrl() == null) {
            showFirstRunDialog();
        } else {
            if (savedInstanceState != null) {
                webView.restoreState(savedInstanceState);
            } else {
                loadApp();
            }
        }
    }

    // ─── URL setup dialogs ────────────────────────────────────────────────────

    /**
     * Shown on very first launch so the user can enter their current ngrok URL.
     */
    private void showFirstRunDialog() {
        EditText input = new EditText(this);
        input.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_TEXT_VARIATION_URI);
        input.setHint("https://xxxx.ngrok-free.app/chat");
        input.setText(DEFAULT_URL);
        input.setPadding(48, 24, 48, 24);

        new AlertDialog.Builder(this)
            .setTitle("Welcome to Chat App")
            .setMessage("Enter your ngrok server URL to connect.\n\nYou can change this any time by long-pressing on the error screen.")
            .setView(input)
            .setCancelable(false)
            .setPositiveButton("Connect", (dialog, which) -> {
                String url = input.getText().toString().trim();
                if (url.isEmpty()) url = DEFAULT_URL;
                if (!url.startsWith("http")) url = "https://" + url;
                saveUrl(url);
                loadApp();
            })
            .setNegativeButton("Use Default", (dialog, which) -> {
                saveUrl(DEFAULT_URL);
                loadApp();
            })
            .show();
    }

    /**
     * Shown when the user long-presses the error screen or WebView → change ngrok URL at runtime.
     */
    private void showUrlSettingsDialog() {
        EditText input = new EditText(this);
        input.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_TEXT_VARIATION_URI);
        input.setText(getAppUrl());
        input.setSelectAllOnFocus(true);
        input.setPadding(48, 24, 48, 24);

        new AlertDialog.Builder(this)
            .setTitle("Change Server URL")
            .setMessage("Update the ngrok URL. Long-press the error screen any time to access this dialog.")
            .setView(input)
            .setPositiveButton("Save & Reload", (dialog, which) -> {
                String url = input.getText().toString().trim();
                if (url.isEmpty()) return;
                if (!url.startsWith("http")) url = "https://" + url;
                saveUrl(url);
                loadApp();
                Toast.makeText(this, "URL updated!", Toast.LENGTH_SHORT).show();
            })
            .setNegativeButton("Cancel", null)
            .show();
    }

    // ─── WebView setup ────────────────────────────────────────────────────────

    @SuppressLint("SetJavaScriptEnabled")
    private void setupWebView() {
        WebSettings settings = webView.getSettings();

        settings.setJavaScriptEnabled(true);
        settings.setDomStorageEnabled(true);
        settings.setDatabaseEnabled(true);
        settings.setGeolocationEnabled(true);
        settings.setAllowFileAccess(true);
        settings.setAllowContentAccess(true);
        settings.setMediaPlaybackRequiresUserGesture(false);
        settings.setSupportMultipleWindows(false);
        settings.setLoadWithOverviewMode(true);
        settings.setUseWideViewPort(true);
        settings.setBuiltInZoomControls(false);
        settings.setDisplayZoomControls(false);
        settings.setSupportZoom(false);
        settings.setTextZoom(100);
        settings.setCacheMode(WebSettings.LOAD_DEFAULT);

        // Identify as Android wrapper app
        String ua = settings.getUserAgentString();
        settings.setUserAgentString(ua + " ChatAppAndroid/1.0");

        settings.setMixedContentMode(WebSettings.MIXED_CONTENT_COMPATIBILITY_MODE);

        // JS bridge
        webView.addJavascriptInterface(new AndroidBridge(), "AndroidApp");

        // ── WebViewClient ──────────────────────────────────────────────────
        webView.setWebViewClient(new WebViewClient() {

            @Override
            public void onPageStarted(WebView view, String url, Bitmap favicon) {
                super.onPageStarted(view, url, favicon);
                progressBar.setVisibility(View.VISIBLE);
                errorLayout.setVisibility(View.GONE);
            }

            @Override
            public void onPageFinished(WebView view, String url) {
                super.onPageFinished(view, url);
                progressBar.setVisibility(View.GONE);
                swipeRefreshLayout.setRefreshing(false);

                // Tell the web app it's running inside the Android app
                view.evaluateJavascript(
                    "window.isAndroidApp = true; " +
                    "document.documentElement.setAttribute('data-platform', 'android');",
                    null
                );
            }

            @Override
            public void onReceivedError(WebView view, WebResourceRequest request,
                                        WebResourceError error) {
                if (request.isForMainFrame()) {
                    progressBar.setVisibility(View.GONE);
                    swipeRefreshLayout.setRefreshing(false);
                    showError("Cannot connect to server.\n\nMake sure ngrok is running.\n\n" +
                              "Long-press here to change the server URL.");
                }
            }

            @Override
            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
                String url = request.getUrl().toString();
                // Stay inside the WebView for ngrok / local URLs
                if (url.contains("ngrok") || url.contains("localhost") ||
                    url.contains("127.0.0.1") || url.contains("192.168.")) {
                    return false;
                }
                // Open external links in the system browser
                if (url.startsWith("http")) {
                    startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse(url)));
                    return true;
                }
                return false;
            }
        });

        // ── WebChromeClient ────────────────────────────────────────────────
        webView.setWebChromeClient(new WebChromeClient() {

            @Override
            public void onProgressChanged(WebView view, int newProgress) {
                progressBar.setProgress(newProgress);
                if (newProgress == 100) progressBar.setVisibility(View.GONE);
            }

            @Override
            public boolean onShowFileChooser(WebView wv, ValueCallback<Uri[]> cb,
                                             FileChooserParams params) {
                if (filePathCallback != null) filePathCallback.onReceiveValue(null);
                filePathCallback = cb;
                openFileChooser(params);
                return true;
            }

            @Override
            public void onGeolocationPermissionsShowPrompt(String origin,
                                                           GeolocationPermissions.Callback cb) {
                cb.invoke(origin, true, false);
            }

            @Override
            public void onPermissionRequest(PermissionRequest request) {
                request.grant(request.getResources());
            }

            @Override
            public boolean onConsoleMessage(ConsoleMessage msg) {
                return true;
            }

            // ── Fullscreen video ──────────────────────────────────────────
            private View customView;
            private CustomViewCallback customViewCallback;

            @Override
            public void onShowCustomView(View view, CustomViewCallback callback) {
                if (customView != null) { onHideCustomView(); return; }
                customView = view;
                customViewCallback = callback;
                FrameLayout container = new FrameLayout(MainActivity.this);
                container.addView(customView);
                getWindow().addFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
                setContentView(container);
            }

            @Override
            public void onHideCustomView() {
                if (customView == null) return;
                setContentView(R.layout.activity_main);
                getWindow().clearFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
                customView = null;
                customViewCallback.onCustomViewHidden();
            }
        });
    }

    // ─── Load / error ─────────────────────────────────────────────────────────

    private void loadApp() {
        errorLayout.setVisibility(View.GONE);
        progressBar.setVisibility(View.VISIBLE);
        
        java.util.Map<String, String> extraHeaders = new java.util.HashMap<>();
        extraHeaders.put("ngrok-skip-browser-warning", "1");
        
        webView.loadUrl(getAppUrl(), extraHeaders);
    }

    private void showError(String message) {
        errorLayout.setVisibility(View.VISIBLE);
        errorText.setText(message);
    }

    // ─── File chooser ─────────────────────────────────────────────────────────

    private void openFileChooser(WebChromeClient.FileChooserParams params) {
        Intent[] intentArray;
        try {
            Intent cameraIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
            File photoFile = createImageFile();
            cameraPhotoUri = FileProvider.getUriForFile(this,
                getPackageName() + ".fileprovider", photoFile);
            cameraIntent.putExtra(MediaStore.EXTRA_OUTPUT, cameraPhotoUri);
            intentArray = new Intent[]{cameraIntent};
        } catch (IOException e) {
            intentArray = new Intent[0];
        }

        Intent contentIntent = params.createIntent();
        Intent chooser = new Intent(Intent.ACTION_CHOOSER);
        chooser.putExtra(Intent.EXTRA_INTENT, contentIntent);
        chooser.putExtra(Intent.EXTRA_TITLE, "Select File");
        chooser.putExtra(Intent.EXTRA_INITIAL_INTENTS, intentArray);
        startActivityForResult(chooser, REQUEST_SELECT_FILE);
    }

    private File createImageFile() throws IOException {
        String stamp = new SimpleDateFormat("yyyyMMdd_HHmmss", Locale.getDefault()).format(new Date());
        File dir = getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        return File.createTempFile("JPEG_" + stamp + "_", ".jpg", dir);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == RC_SIGN_IN) {
            Task<GoogleSignInAccount> task = GoogleSignIn.getSignedInAccountFromIntent(data);
            handleSignInResult(task);
            return;
        }

        if (requestCode != REQUEST_SELECT_FILE || filePathCallback == null) return;
        Uri[] results = null;
        if (resultCode == Activity.RESULT_OK) {
            if (data == null || data.getData() == null) {
                if (cameraPhotoUri != null) results = new Uri[]{cameraPhotoUri};
            } else {
                String ds = data.getDataString();
                if (ds != null) results = new Uri[]{Uri.parse(ds)};
            }
        }
        filePathCallback.onReceiveValue(results);
        filePathCallback = null;
    }

    // ─── Google Sign-In & Drive Auth ──────────────────────────────────────────

    private void requestGoogleDriveAuth(String webClientId) {
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestEmail()
                .requestIdToken(webClientId)
                .requestScopes(new Scope("https://www.googleapis.com/auth/drive.file"))
                .build();

        GoogleSignInClient mGoogleSignInClient = GoogleSignIn.getClient(this, gso);
        Intent signInIntent = mGoogleSignInClient.getSignInIntent();
        startActivityForResult(signInIntent, RC_SIGN_IN);
    }

    private void handleSignInResult(Task<GoogleSignInAccount> completedTask) {
        try {
            GoogleSignInAccount account = completedTask.getResult(ApiException.class);
            if (account != null && account.getAccount() != null) {
                // Fetch token in background
                executorService.execute(() -> {
                    try {
                        String scope = "oauth2:https://www.googleapis.com/auth/drive.file";
                        String token = GoogleAuthUtil.getToken(MainActivity.this, account.getAccount(), scope);
                        runOnUiThread(() -> {
                            webView.evaluateJavascript("if(window.onAndroidDriveAuthSuccess) window.onAndroidDriveAuthSuccess('" + token + "');", null);
                        });
                    } catch (Exception e) {
                        e.printStackTrace();
                        runOnUiThread(() -> Toast.makeText(MainActivity.this, "Failed to get auth token", Toast.LENGTH_SHORT).show());
                    }
                });
            }
        } catch (ApiException e) {
            e.printStackTrace();
            Toast.makeText(this, "Google Sign-In failed: " + e.getStatusCode(), Toast.LENGTH_SHORT).show();
            // Optional: send failure callback to JS
            webView.evaluateJavascript("if(window.onAndroidDriveAuthFailed) window.onAndroidDriveAuthFailed();", null);
        }
    }

    // ─── Permissions ──────────────────────────────────────────────────────────

    private void requestAllPermissions() {
        List<String> needed = new ArrayList<>();
        String[] always = {
            Manifest.permission.CAMERA,
            Manifest.permission.RECORD_AUDIO,
            Manifest.permission.ACCESS_FINE_LOCATION,
            Manifest.permission.ACCESS_COARSE_LOCATION,
            Manifest.permission.READ_CONTACTS,
        };
        for (String p : always) {
            if (ContextCompat.checkSelfPermission(this, p) != PackageManager.PERMISSION_GRANTED)
                needed.add(p);
        }
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
            needed.add(Manifest.permission.POST_NOTIFICATIONS);
            needed.add(Manifest.permission.READ_MEDIA_IMAGES);
            needed.add(Manifest.permission.READ_MEDIA_VIDEO);
            needed.add(Manifest.permission.READ_MEDIA_AUDIO);
        } else {
            needed.add(Manifest.permission.READ_EXTERNAL_STORAGE);
        }
        if (!needed.isEmpty()) {
            ActivityCompat.requestPermissions(this, needed.toArray(new String[0]), REQUEST_PERMISSIONS);
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions,
                                           @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == REQUEST_PERMISSIONS) webView.reload();
    }

    // ─── Back button ──────────────────────────────────────────────────────────

    @Override
    public void onBackPressed() {
        if (webView.canGoBack()) webView.goBack();
        else super.onBackPressed();
    }

    // ─── State ────────────────────────────────────────────────────────────────

    @Override
    protected void onSaveInstanceState(@NonNull Bundle out) {
        super.onSaveInstanceState(out);
        webView.saveState(out);
    }

    @Override
    protected void onRestoreInstanceState(@NonNull Bundle saved) {
        super.onRestoreInstanceState(saved);
        webView.restoreState(saved);
    }

    @Override protected void onResume()  { super.onResume();  webView.onResume(); }
    @Override protected void onPause()   { webView.onPause(); super.onPause();    }
    @Override protected void onDestroy() { webView.destroy(); super.onDestroy();  }

    // ─── JavaScript Bridge ────────────────────────────────────────────────────

    class AndroidBridge {

        @JavascriptInterface
        public void showToast(String message) {
            runOnUiThread(() ->
                Toast.makeText(MainActivity.this, message, Toast.LENGTH_SHORT).show()
            );
        }

        @JavascriptInterface
        public boolean isAndroidApp() { return true; }

        @JavascriptInterface
        public void reloadApp() { runOnUiThread(() -> webView.reload()); }

        @JavascriptInterface
        public String getAppUrl() { return MainActivity.this.getAppUrl(); }

        @JavascriptInterface
        public void requestGoogleDriveAuth(String webClientId) {
            runOnUiThread(() -> MainActivity.this.requestGoogleDriveAuth(webClientId));
        }

        /** Called from JS to open the URL-settings dialog (e.g., on server error) */
        @JavascriptInterface
        public void openUrlSettings() {
            runOnUiThread(() -> showUrlSettingsDialog());
        }
    }
}
