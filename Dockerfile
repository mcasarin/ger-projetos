# Use uma imagem oficial do Node.js
FROM node:18-alpine

# Defina o diretório de trabalho dentro do contêiner
WORKDIR /app

# Copie os arquivos de dependência
COPY package*.json ./

# Instale as dependências
RUN npm install

# Copie o restante do código
COPY . .

# Exponha a porta que o app vai rodar
EXPOSE 3000

# Comando para rodar a aplicação
CMD ["node", "index.js"]
