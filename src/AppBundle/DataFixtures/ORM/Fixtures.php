<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tag;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Fixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Tags
        $faker = \Faker\Factory::create();
        $tags = [];
        for ($i = 0; $i < 20; $i++) {
            $tag = new Tag();
            $tag->setName($faker->name);
            $tags[] = $tag;
            $manager->persist($tag);
        }

        // Articles
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->name);
            $article->setContent($faker->text);
            $articleTags = [];
            for($i2 = 0; $i2 < 5; $i2++) {
                $tag = $tags[rand(0, 19)];
                if (!in_array($tag, $articleTags)) {
                    $articleTags[] = $tag;
                    $article->addTag($tag);
                }
            }
            $manager->persist($article);
        }

        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEmail('roland.kuku@gmail.com');
        $user->setUsername('roland');
        $user->setPassword('secret');
        $user->setEnabled(true);
        $user->addRole('ROLE_SUPER_ADMIN');

        $userManager->updateUser($user, true);

        $manager->flush();
    }
}