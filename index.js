// index.js
const express = require('express');
const app = express();
const port = 3100;
app.get('/', (req, res) => {
    res.send('Hello, Gerenciador de projetos!');
});
app.listen(port, () => {
    console.log(`Servidor disponível em: http://localhost:${port}/`);
});
