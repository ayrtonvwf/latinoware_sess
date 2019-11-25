# Requirements

Ok, it uses PHP (only ever tested on 7.3, three days before this talk. Might work as well on most nearly up to date versions). 

# Setup

Clone this repo to your local machine.

If you have composer set up, run:
```composer serve```

Otherwise:
```php -S localhost:8000 -d session.save_path='./session' -d xdebug.remote_enable=1 -d xdebug.remote_autostart=1```

This will start the PHP built-in server, with the right session path and with debugging enabled (just in case).

You should be able to access it on [http://locahost:8000](http://localhost:8000)

# Parental advisory

This project is meant to be used as a interactive demonstration tool on the Ayrton Fidelis's at Latinoware 2019.

It's a mess.

Really, it should be used only as an oversimplified demonstration of the concepts presented on the talk.

NEVER take any piece of this code to production.

I know, I shouldn't upload the `./vendor` folder to the source control. But I did. In purpouse. The setup should be really quick for this talk and you will probably regret depending on `composer install` over any event's network.

I know, the code could be a lot nicer. It could make use of many freshly baked PHP features, but for the sake of the friendship with those who are just getting started with coding: lets oversimplify the code as much as possible.

I know, the naming is bad. It's purpose is only to keep files in order to the presentation.
