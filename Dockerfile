FROM ghcr.io/unb-libraries/drupal:9.x-2.x-unblib
MAINTAINER UNB Libraries <libsupport@unb.ca>

# Install additional OS packages.
ENV ADDITIONAL_OS_PACKAGES postfix php7-ldap php7-xmlreader php7-zip imagemagick php7-redis
ENV DRUPAL_SITE_ID aaslp
ENV DRUPAL_SITE_URI slaveryandfreedomlaws.lib.unb.ca
ENV DRUPAL_SITE_UUID 842a4c70-3da8-41a9-8948-9dbec80be2bd

# Build application.
COPY ./build/ /build/
RUN ${RSYNC_MOVE} /build/scripts/container/ /scripts/ && \
  /scripts/addOsPackages.sh && \
  /scripts/initOpenLdap.sh && \
  /scripts/setupStandardConf.sh && \
  /scripts/build.sh

# Deploy configuration.
COPY ./config-yml ${DRUPAL_CONFIGURATION_DIR}
RUN /scripts/pre-init.d/72_secure_config_sync_dir.sh

# Deploy custom modules, themes.
COPY ./custom/themes ${DRUPAL_ROOT}/themes/custom
COPY ./custom/modules ${DRUPAL_ROOT}/modules/custom

# Container metadata.
LABEL ca.unb.lib.generator="drupal9" \
  com.microscaling.docker.dockerfile="/Dockerfile" \
  com.microscaling.license="MIT" \
  org.label-schema.build-date=$BUILD_DATE \
  org.label-schema.description="slaveryandfreedomlaws.lib.unb.ca is the slaveryandfreedomlaws application at UNB Libraries." \
  org.label-schema.name="slaveryandfreedomlaws.lib.unb.ca" \
  org.label-schema.schema-version="1.0" \
  org.label-schema.url="https://slaveryandfreedomlaws.lib.unb.ca" \
  org.label-schema.vcs-ref=$VCS_REF \
  org.label-schema.vcs-url="https://github.com/unb-libraries/slaveryandfreedomlaws.lib.unb.ca" \
  org.label-schema.vendor="University of New Brunswick Libraries" \
  org.label-schema.version=$VERSION \
  org.opencontainers.image.source="https://github.com/unb-libraries/slaveryandfreedomlaws.lib.unb.ca"
