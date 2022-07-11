#!/bin/bash

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion

#WORK_DIR=/home/ubuntu/bryg

cd /home/ubuntu/oa-omr


find /home/ubuntu/oa-omr/storage/ -type d -exec chmod 777 {} \;
find /home/ubuntu/oa-omr/storage/ -type f -exec chmod 666 {} \;

# cd /home/ubuntu/bryg/packages/Webkul/Admin && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/Custom && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/CustomerDocument && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/PreOrder && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/SAASCustomizer && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/Shop && npm i && npm run production
#cd /home/ubuntu/bryg/packages/Webkul/ShowPriceAfterLogin && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/StripeConnect && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Ecommvu/StripeConnect && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Webkul/Ui && npm i && npm run production
# cd /home/ubuntu/bryg/packages/Razzo/DeliveryDate && npm i && npm run production

cd /home/ubuntu/oa-omr && php ./composer.phar install --no-dev

cd /home/ubuntu/oa-omr && php ./artisan storage:link
#cd /home/ubuntu/oa-omr && php ./artisan vendor:publish --all --force

cd /home/ubuntu/oa-omr && npm i && npm run production
