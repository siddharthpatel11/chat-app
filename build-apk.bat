@echo off
echo ============================================================
echo  Chat App - Android APK Builder
echo ============================================================
echo.

:: Check if JAVA_HOME is set
if "%JAVA_HOME%"=="" (
    echo [ERROR] JAVA_HOME is not set.
    echo.
    echo Please install JDK 17 from:
    echo   https://adoptium.net/
    echo.
    echo After installing, set JAVA_HOME to your JDK folder, e.g.:
    echo   setx JAVA_HOME "C:\Program Files\Eclipse Adoptium\jdk-17.x.x.x-hotspot"
    echo.
    pause
    exit /b 1
)

echo [OK] JAVA_HOME = %JAVA_HOME%
echo.

:: Check for ANDROID_HOME
if "%ANDROID_HOME%"=="" (
    if "%ANDROID_SDK_ROOT%"=="" (
        echo [WARNING] ANDROID_HOME is not set.
        echo Gradle will try to use the local SDK from Android Studio if installed.
        echo If build fails, install Android Studio from: https://developer.android.com/studio
        echo.
    )
)

cd /d "%~dp0android-app"

echo [BUILD] Running Gradle assembleDebug ...
echo.
call gradlew.bat assembleDebug --no-daemon

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo [FAILED] Build failed. Check errors above.
    pause
    exit /b 1
)

echo.
echo [OK] Build succeeded!
echo.

:: Copy APK to public/download
set APK_SRC=app\build\outputs\apk\debug\app-debug.apk
set APK_DEST=..\public\download\chat-app.apk

if not exist "..\public\download" mkdir "..\public\download"
copy /Y "%APK_SRC%" "%APK_DEST%"

echo [OK] APK copied to: public\download\chat-app.apk
echo.
echo Users can now download it via: /download/app
echo.
pause
