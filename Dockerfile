FROM devwithlando/php:7.3-fpm-2

# Choose the major node version
ENV NODE_VERSION=12

# Install node
RUN curl -sL "https://deb.nodesource.com/setup_${NODE_VERSION}.x" | bash - && apt-get install -y nodejs

# Install yarn
RUN curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update
RUN apt-get install -y yarn

# Add support for yaml.
RUN apt-get install -y libyaml-dev
RUN yes | pecl install yaml
RUN echo 'extension=yaml.so' > /usr/local/etc/php/conf.d/yaml.ini

# Add other dependencies.
RUN apt-get install -y gnupg
RUN apt-get install -y zip
RUN apt-get install -y subversion

# Add dependency for AMP plugin
RUN apt-get install -y protobuf-compiler python-protobuf
