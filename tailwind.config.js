/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.{html,js,php,json}", // Menyertakan semua file HTML, JS, PHP, dan JSON di seluruh proyek
  ],
  theme: {
    extend: {
      // Menambahkan font "Inter" ke dalam tema
      fontFamily: {
        'inter': ["'Inter'", 'sans-serif']
      },
      // Menambahkan background image untuk select-arrow
      backgroundImage: {
        'select-arrow': 'url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZD0iTTExLjk5OTcgMTMuMTcxNEwxNi45NDk1IDguMjIxNjhMMTguMzYzNyA5LjYzNTg5TDExLjk5OTcgMTUuOTk5OUw1LjYzNTc0IDkuNjM1ODlMNy4wNDk5NiA4LjIyMTY4TDExLjk5OTcgMTMuMTcxNFoiIGZpbGw9InJnYmEoMTU2LDE2MywxNzUsMSkiPjwvcGF0aD48L3N2Zz4=")'
      },
      // Menambahkan breakpoint custom tanpa menimpa yang default
      screens: {
        '2xs': { min: '300px' },
        'xs': { max: '575px' }, // Mobile (iPhone 3 - iPhone XS Max)

      }
    },
  },
  plugins: [],
}
