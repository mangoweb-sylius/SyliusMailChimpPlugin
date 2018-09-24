<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://instagram.fprg2-1.fna.fbcdn.net/vp/991077ebaa238f3ddbeff40bfefdd6f4/5C5EE60B/t51.2885-19/s150x150/12394163_769607056476857_462554822_a.jpg" height="75"/>
    </a>
    <a href="http://sylius.com" title="Sylius" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" width="300" />
    </a>
</p>
<h1 align="center">MailChimp Plugin</h1>


## Installation

1. Run `$ composer require mangoweb-sylius/sylius-mailchimp-plugin`.

2. Add plugin dependencies to your AppKernel.php

```php
public function registerBundles()
{
	...
	$bundles[] = new \MangoSylius\MailChimpPlugin\MangoSyliusMailChimpPlugin();
}
```

### Development

#### Usage (docker-only)

- Create symlink from `tests/Application.env.dist` to `tests/Application/.env` or create your own .env file
- Use php and composer from bin-docker (You can use [direnv](https://direnv.net) to add it into path)
- Run `bin-docker/composer install`, (or just composer, if you are using direnv)
- Develop you plugin in `/src`
- See [.gitlab-ci.yml](.gitlab-ci.yml) and [docker-compose.yaml](docker-compose.yaml) for more info about testing
- See `bin/` for useful commands
