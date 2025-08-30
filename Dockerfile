FROM node:lts

WORKDIR /home/marcio/ger-projetos

COPY package.json ./app/src

RUN npm install

COPY . .

EXPOSE 3100

CMD [ "node", "start" ]
