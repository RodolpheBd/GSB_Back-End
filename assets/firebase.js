import { initializeApp } from "firebase/app";
import { getFirestore } from "firebase/firestore";
import { getDatabase } from "firebase/database";
import { getAuth } from "firebase/auth";

const firebaseConfig = {
  apiKey: "AIzaSyCRE3GU-8cx2S_b-Gb9qq-lvothREZCZgE",
  authDomain: "gsbapp-211f3.firebaseapp.com",
  projectId: "gsbapp-211f3",
  storageBucket: "gsbapp-211f3.firebasestorage.app",
  messagingSenderId: "207276688155",
  appId: "1:207276688155:web:9ef0d4b4a60f3cea4209be"
};

const app = initializeApp(firebaseConfig);
const firebaseDB = getFirestore(app);
const firebaseDatabase = getDatabase(app);
const firebaseAuth = getAuth(app);

export { firebaseDB, firebaseDatabase, firebaseAuth };