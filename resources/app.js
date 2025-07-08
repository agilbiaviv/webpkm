// resources/app.js

import { createIcons, icons } from 'lucide';

// Inisialisasi icons setelah DOM siap
document.addEventListener('DOMContentLoaded', () => {
  AOS.init({
      duration: 800,
      once: true,
      offset: 50,
      easing: 'ease-in-out',
  });
  
  createIcons({icons});
});
