const { app, BrowserWindow, ipcMain, nativeImage } = require('electron')
const path = require('path')

function createWindow () {
  // Create the browser window.
  const mainWindow = new BrowserWindow({
    width: 1200,
    height: 800,
    icon: path.join(__dirname, 'icon.png'),
    webPreferences: {
      nodeIntegration: false,
      contextIsolation: true,
      preload: path.join(__dirname, 'preload.js')
    }
  })

  // Handle icon updates from the web app
  ipcMain.on('update-icon', (event, dataUrl) => {
    try {
      const image = nativeImage.createFromDataURL(dataUrl);
      mainWindow.setIcon(image);
    } catch (e) {
      console.error('Failed to update icon:', e);
    }
  })

  // Remove default menu for a clean app look
  mainWindow.setMenuBarVisibility(false)

  // Load the Laravel app URL
  mainWindow.loadURL('http://127.0.0.1:8000')

  // Open the DevTools if you need to debug
  // mainWindow.webContents.openDevTools()
}

app.whenReady().then(() => {
  createWindow()

  app.on('activate', function () {
    if (BrowserWindow.getAllWindows().length === 0) createWindow()
  })
})

app.on('window-all-closed', function () {
  if (process.platform !== 'darwin') app.quit()
})
