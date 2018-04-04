FROM adoniasdantas/leanwriter


#Criando a pasta para o projeto
RUN mkdir /app
ADD . /app
WORKDIR /app


