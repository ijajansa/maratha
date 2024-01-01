importScripts('https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js');

var firebaseConfig = {
  apiKey: "AIzaSyDLNzkSKuszYtoe2U84Uvp7J27Hehg1pd4",
  authDomain: "vegobike-74d6e.firebaseapp.com",
  projectId: "vegobike-74d6e",
  storageBucket: "vegobike-74d6e.appspot.com",
  messagingSenderId: "659522969918",
  appId: "1:659522969918:web:825ffc8c93c7a2686d8c6f",
  measurementId: "G-61BLFF3764"
};

firebase.initializeApp(firebaseConfig);
const messaging=firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification=JSON.parse(payload);
    const notificationOption={
        body:notification.body,
        icon:notification.icon
    };
    return self.registration.showNotification(payload.notification.title,notificationOption);
});