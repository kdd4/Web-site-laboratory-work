ARG NGINX_VERSION=1.29-alpine

FROM nginx:${NGINX_VERSION}

COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

ENTRYPOINT ["nginx", "-c", "/etc/nginx/nginx.conf"]

CMD ["-g", "daemon off;"]