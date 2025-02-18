import globals from 'globals';
import pluginJs from '@eslint/js';
import pluginVue from 'eslint-plugin-vue';
import configPrettier from '@vue/eslint-config-prettier';

/** @type {import('eslint').Linter.Config[]} */
export default [
    {
        files: ['resources/js/*.{js,mjs,cjs,vue}']
    },
    {
        languageOptions: { globals: globals.browser }
    },
    pluginJs.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    {
        rules: {
            'vue/multi-word-component-names': 'warn',
        },
    },
    configPrettier,
];
