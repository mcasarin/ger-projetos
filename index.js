const express = require('express');
const app = express();
const port = 3000;

app.get('/', (req, res) => {
    res.send('Olá do meu contêiner Node.js!');
});

app.listen(port, () => {
    console.log(`Aplicativo rodando em http://localhost:${port}`);
});
