import { createI18n } from 'vue-i18n';
import es from './Lang/es.json';

const i18n = createI18n({
    locale: 'es',
    messages: {
        es: {
            ...es,
        },
    },
});

export { i18n };
