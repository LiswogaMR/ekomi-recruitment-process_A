# Use a base image with PHP pre-installed
FROM php:latest

# Set the working directory in the container
WORKDIR /app

# Copy the project files to the container
COPY . /app

# Install any project dependencies
# For example, if you're using Composer for PHP dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Expose the port where your application runs (if applicable)
EXPOSE 80

# Specify the command to run your application
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
