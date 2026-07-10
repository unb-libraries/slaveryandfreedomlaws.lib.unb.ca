FROM ghcr.io/unb-libraries/drupal:11.x-1.x-unblib

# Install additional OS packages.
ENV ADDITIONAL_OS_PACKAGES="postfix php${PHP_VERSION}-ldap php${PHP_VERSION}-xmlreader php${PHP_VERSION}-zip imagemagick php${PHP_VERSION}-pecl-redis ghostscript"
ENV DRUPAL_SITE_ID="aaslp"
ENV DRUPAL_SITE_URI="slaveryandfreedomlaws.lib.unb.ca"
ENV DRUPAL_SITE_UUID="842a4c70-3da8-41a9-8948-9dbec80be2bd"

# Build application.
COPY ./build/ /build/
RUN ${RSYNC_MOVE} /build/scripts/container/ /scripts/ && \
  /scripts/addOsPackages.sh && \
  /scripts/initOpenLdap.sh && \
  /scripts/setupStandardConf.sh && \
  /scripts/build.sh

# Deploy configuration.
COPY ./configuration ${DRUPAL_CONFIGURATION_DIR}
RUN /scripts/pre-init.d/72_secure_config_sync_dir.sh

# Deploy custom modules, themes.
COPY ./custom/themes ${DRUPAL_ROOT}/themes/custom
COPY ./custom/modules ${DRUPAL_ROOT}/modules/custom

# Container metadata.
LABEL ca.unb.lib.generator="drupal11" \
  org.opencontainers.image.title="slaveryandfreedomlaws.lib.unb.ca" \
  org.opencontainers.image.description="slaveryandfreedomlaws.lib.unb.ca is the slaveryandfreedomlaws application at UNB Libraries." \
  org.opencontainers.image.vendor="University of New Brunswick Libraries" \
  org.opencontainers.image.authors="UNB Libraries <libsupport@unb.ca>" \
  org.opencontainers.image.url="https://slaveryandfreedomlaws.lib.unb.ca" \
  org.opencontainers.image.source="https://github.com/unb-libraries/slaveryandfreedomlaws.lib.unb.ca" \
  org.opencontainers.image.version="$VERSION" \
  org.opencontainers.image.revision="$VCS_REF" \
  org.opencontainers.image.created="$BUILD_DATE"