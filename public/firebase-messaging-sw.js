importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyCTUuLg0mheURhlG1Z0p0DgMRwoAcR-F0w",
    authDomain: "chat-app-a370c.firebaseapp.com",
    databaseURL: "https://chat-app-a370c-default-rtdb.firebaseio.com",
    projectId: "chat-app-a370c",
    messagingSenderId: "1089034732064",
    appId: "1:1016598612026:web:6cc4d1dd4466eec8934d03"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/firebase-logo.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
