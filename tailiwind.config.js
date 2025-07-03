/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/**/*.php',
    './views/**/*.php',
    './resources/**/*.{js,php,html}',
    './public/**/*.html',
  ],
  corePlugins: {
    preflight: false,
  },
  theme: {
    extend: {
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      },
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
  safelist: [
    'bg-gradient-radial',
    'from-orange-300',
    'via-orange-50',
    'to-orange-300',
    'bg-cover',
    'bg-no-repeat',
  ],
  darkMode: "class",
  plugins: [
    require('@tailwindcss/line-clamp')
  ],
 };
