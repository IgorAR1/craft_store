FROM docker.elastic.co/elasticsearch/elasticsearch:8.15.3
LABEL authors="Igoryan"

ENTRYPOINT ["top", "-b"]
