module.exports = {
    plugins: ['@prettier/plugin-php'],
    printWidth: 120, // Largura máxima da linha (ajuste conforme sua preferência)
    tabWidth: 4,    // Tamanho da tabulação (ajuste conforme sua preferência)
    useTabs: false, // Usar espaços em vez de tabs
    semi: true,     // Adicionar ponto e vírgula no final das declarações
    singleQuote: false, // Usar aspas duplas em vez de aspas simples
    trailingComma: 'all', // Adicionar vírgula à direita em arrays e objetos
    bracketSpacing: true, // Adicionar espaço entre colchetes/chaves
    arrowParens: 'always', // Adicionar parênteses em arrow functions (sempre)
    // Adicione outras configurações do Prettier conforme necessário
};