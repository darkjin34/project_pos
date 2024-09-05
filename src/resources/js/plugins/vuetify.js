import 'vuetify/styles'; // Global Vuetify styles
import { createVuetify } from 'vuetify';
import { aliases, mdi } from 'vuetify/iconsets/mdi'; // Optional: If you're using Material Design Icons

const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  theme: {
    defaultTheme: 'light',
  },
});

export default vuetify;