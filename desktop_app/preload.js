const { contextBridge, ipcRenderer } = require('electron')

contextBridge.exposeInMainWorld('electronAPI', {
  updateIcon: (dataUrl) => ipcRenderer.send('update-icon', dataUrl)
})
