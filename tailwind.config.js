/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
  ],
  theme: {
      extend: {},
  },
  darkMode: 'class', // Enable dark mode with class strategy
  plugins: [],
}
