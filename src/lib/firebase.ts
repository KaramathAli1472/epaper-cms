import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';
import { getFirestore } from 'firebase/firestore';
import { getStorage } from 'firebase/storage';

const firebaseConfig = {
  apiKey: 'AIzaSyA5RtTPwJiPovHk6McFTob14apTPndZyUc',
  authDomain: 'sadaehussaini-44658.firebaseapp.com',
  projectId: 'sadaehussaini-44658',
  storageBucket: 'sadaehussaini-44658.appspot.com',
  appId: '1:93243525487:web:0d329930cc1fd4021b809a',
};

const app = initializeApp(firebaseConfig);
export const auth = getAuth(app);
export const db = getFirestore(app);
export const storage = getStorage(app);
