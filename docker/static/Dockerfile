FROM node:12-slim

WORKDIR /code

ADD package*.json ./

RUN npm install

COPY . ./

ENTRYPOINT ["npm"]
