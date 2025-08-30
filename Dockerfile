FROM node:lts

WORKDIR /home/marcio/ger-projetos

COPY package.json ./

RUN npm install

COPY . .

EXPOSE 3100

CMD [ "node", "start" ]
