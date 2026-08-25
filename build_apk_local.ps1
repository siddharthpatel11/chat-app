$ProgressPreference = 'SilentlyContinue'
$ErrorActionPreference = "Stop"

$workspace = "d:\xampp\htdocs\laravel\chat_app"
$buildToolsDir = "$workspace\build-tools"
$jdkDir = "$buildToolsDir\jdk-17.0.12+7"
$androidSdkDir = "$buildToolsDir\android-sdk"
$cmdlineToolsDir = "$androidSdkDir\cmdline-tools\latest"

# 1. Create build tools directory
if (!(Test-Path $buildToolsDir)) {
    New-Item -ItemType Directory -Path $buildToolsDir | Out-Null
}

# 2. Download and Extract OpenJDK 17
if (!(Test-Path $jdkDir)) {
    Write-Host "Downloading OpenJDK 17..."
    $jdkZip = "$buildToolsDir\jdk.zip"
    if (!(Test-Path $jdkZip)) {
        curl.exe -sSL "https://github.com/adoptium/temurin17-binaries/releases/download/jdk-17.0.12%2B7/OpenJDK17U-jdk_x64_windows_hotspot_17.0.12_7.zip" -o $jdkZip
    }
    Write-Host "Extracting OpenJDK 17..."
    Expand-Archive -Path $jdkZip -DestinationPath $buildToolsDir -Force
    # The extracted folder is named "jdk-17.0.12+7"
}

# 3. Download and Extract Android Command Line Tools
if (!(Test-Path $cmdlineToolsDir)) {
    Write-Host "Downloading Android SDK Command-line Tools..."
    $cmdlineZip = "$buildToolsDir\cmdline-tools.zip"
    if (!(Test-Path $cmdlineZip)) {
        curl.exe -sSL "https://dl.google.com/android/repository/commandlinetools-win-11076708_latest.zip" -o $cmdlineZip
    }
    Write-Host "Extracting Android SDK..."
    # Need to extract to cmdline-tools\latest
    $tempExtract = "$buildToolsDir\cmdline-temp"
    if (Test-Path $tempExtract) { Remove-Item -Recurse -Force $tempExtract }
    Expand-Archive -Path $cmdlineZip -DestinationPath $tempExtract -Force
    
    New-Item -ItemType Directory -Path "$androidSdkDir\cmdline-tools" -Force | Out-Null
    Move-Item -Path "$tempExtract\cmdline-tools" -Destination $cmdlineToolsDir -Force
    Remove-Item -Recurse -Force $tempExtract
}

# 4. Set Environment Variables for this session
$env:JAVA_HOME = $jdkDir
$env:ANDROID_HOME = $androidSdkDir
$env:Path = "$env:JAVA_HOME\bin;$env:ANDROID_HOME\cmdline-tools\latest\bin;$env:Path"

Write-Host "JAVA_HOME set to $env:JAVA_HOME"
Write-Host "ANDROID_HOME set to $env:ANDROID_HOME"

# 5. Accept Android SDK Licenses
Write-Host "Accepting Android SDK Licenses..."
Start-Process -FilePath "cmd.exe" -ArgumentList "/c echo y| sdkmanager --licenses" -Wait -NoNewWindow

# 6. Build APK
Write-Host "Building APK with Gradle..."
Set-Location "$workspace\android-app"
& ".\gradlew.bat" assembleDebug

if ($LASTEXITCODE -eq 0) {
    Write-Host "Build Successful!"
    # 7. Copy APK to public/download
    $apkSource = "$workspace\android-app\app\build\outputs\apk\debug\app-debug.apk"
    $apkDestDir = "$workspace\public\download"
    if (!(Test-Path $apkDestDir)) {
        New-Item -ItemType Directory -Path $apkDestDir | Out-Null
    }
    Copy-Item -Path $apkSource -Destination "$apkDestDir\chat-app.apk" -Force
    Write-Host "APK copied to $apkDestDir\chat-app.apk"
} else {
    Write-Host "Build Failed with exit code $LASTEXITCODE"
    exit 1
}
