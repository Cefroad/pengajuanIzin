/** @type {import('tailwindcss').Config} */
module.exports = {
  experimental: {
    optimizeUniversalDefaults: true, // Adding the experimental option
  },
  content: [
    "./**/*.{html,js,php,json}",  // Include HTML, JS, PHP, JSON files
    "!./node_modules",            // Exclude the node_modules folder for better performance
  ],
  theme: {
    extend: {
      // Adding "Inter" font family to the theme
      fontFamily: {
        'inter': ["'Inter'", 'sans-serif']
      },
      // Adding custom background image for select-arrow
      backgroundImage: {
        'select-arrow': 'url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZD0iTTExLjk5OTcgMTMuMTcxNEwxNi45NDk1IDguMjIxNjhMMTguMzYzNyA5LjYzNTg5TDExLjk5OTcgMTUuOTk5OUw1LjYzNTc0IDkuNjM1ODlMNy4wNDk5NiA4LjIyMTY4TDExLjk5OTcgMTMuMTcxNFoiIGZpbGw9InJnYmEoMTU2LDE2MywxNzUsMSkiPjwvcGF0aD48L3N2Zz4=")'
      },
      // Adding custom breakpoints without overriding default ones
      screens: {
        '2xs': { min: '300px' },
        'xs': { max: '575px' }, // Mobile (iPhone 3 - iPhone XS Max)
      },
      animation: {
        shake:'shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97)'
      },
      keyframes: {
        shake : {
          '10%, 90%': {
              transform: 'translate3d(-1px, 0, 0)'
          },
          '20%, 80%': {
              transform: 'translate3d(2px, 0, 0)'
          },
          '30%, 50%, 70%': {
              transform: 'translate3d(-4px, 0, 0)'
          },
          '40%, 60%': {
              transform: 'translate3d(4px, 0, 0)'
          }
        }
      }
    },
  },
  plugins: [],
}
