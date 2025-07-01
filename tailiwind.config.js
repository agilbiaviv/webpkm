/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/**/*.php',
    './views/**/*.php',
    './resources/**/*.{js,php,html}',
    './public/**/*.html',
  ],
  theme: {
    extend: {
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
      },
      animation: {
        'fade-in': 'fadeIn 1s ease-in-out forwards',
      },
      fontFamily: {
        sans: ["InterVariable", "ui-sans-serif", "system-ui", "sans-serif"],
      },
      colors: {
        primary: "#1e40af",
      },
    },
  },
  darkMode: "class",
  plugins: [],
};
