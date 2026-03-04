ARG NODE_VERSION=24-alpine
ARG NGINX_VERSION=1.29-alpine

FROM node:${NODE_VERSION} AS builder

WORKDIR /app

COPY frontend/package.json frontend/package-lock.json ./

RUN --mount=type=cache,target=/root/.npm npm clean-install

COPY frontend .

RUN npm run build


FROM nginx:${NGINX_VERSION} AS runner

COPY nginx.conf /etc/nginx/nginx.conf

COPY --chown=nginx:nginx --from=builder /app/dist /usr/share/nginx/html

EXPOSE 8080

ENTRYPOINT ["nginx", "-c", "/etc/nginx/nginx.conf"]

CMD ["-g", "daemon off;"]