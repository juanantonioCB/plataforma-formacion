/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue"
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Open Sans', 'sans-serif']
      },
      fontSize: {
        'sm_base': ['0.9em','1.2em']
      },
      lineHeight: {
        '11': '3rem',
        '12': '3.5rem',
      },
    },
    container: {
      center: true,
    },
    colors: {
      'white': '#ffffff',
      'gris': '#999',
      'gris2': '#6a6a6a',
      'gris3': '#59646D',
      'gris4': '#DEDEDE',
      'gris5': '#bbbbbb',
      'p_p_rojo': '#e73137',
      'p_p_amarillo': '#ffdd00',
      'p_p_gris_claro': '#68757e',
      'p_p_gris_oscuro': '#4b5c66',
      'p_s_marron': '#79262a',
      'p_s_azul': '#009cdd',
      'p_s_verde': '#8ad000'
    },
    
    
  },
  plugins: [],
}
