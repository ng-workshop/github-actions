FROM docker:dind

ENV SCANNER=trivy
ENV PATH="/root:${PATH}"

COPY --from=registry.gitlab.com/security-products/container-scanning:4 --chown=root:root /home/gitlab/ /root/

WORKDIR /root

RUN apk add --update --virtual build-deps bash curl wget \
    && apk add --update --no-cache ca-certificates git ruby \
    && mkdir -p /usr/local/share/ca-certificates /usr/lib/ssl/certs/ \
    && chown root /usr/local/share/ca-certificates /usr/lib/ssl/certs/ \
    && chmod -R g+rw /usr/local/share/ca-certificates/ /usr/lib/ssl/certs/ \
    && gem install --no-document gcs.gem \
    && bash setup.sh \
    && apk del --purge build-deps \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

CMD ["gtcs", "scan"]
