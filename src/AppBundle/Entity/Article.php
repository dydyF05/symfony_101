<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
*/
class Article
{

    public function __construct() {
        $this->tags = new ArrayCollection();
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
        $this->removed = false;
    }


    /**
     * @var integer
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     * @ORM\Column(name="published", type="boolean", options={"default": true})
     */
    private $published;

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param mixed $published
     * @return $this
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * Get the value of tags
     * @return array
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set the value of tags
     * @param array
     * @return self
     */
    public function setTags($tags) {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Removes a tag
     * @param Appbundle\Entity\Tag
     * @return self
     */
    public function removeTag($tag) {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * Adds a tag
     * @param Appbundle\Entity\Tag
     * @return self
     */
    public function addTag($tag) {
        $this->tags->add($tag);

        return $this;
    }

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    /**
     * Get the value of slug
     * @return string slug
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @var string
    *
    * @ORM\Column(name="title", type="string")
    */
    private $title;

    /**
     * @var DateTime
    * 
    * @ORM\Column(name="createdAt", type="datetime")
    */
    private $createdAt;

    /**
     * @var DateTime
    * 
    * @ORM\Column(type="datetime")
    * @Gedmo\Timestampable(on="update")
    */
    private $updatedAt;

    /**
     * @var string
    *
    * @ORM\Column(name="content", type="text")
    */
    private $content;

    /**
     * @var boolean
     * @ORM\Column(name="removed", type="boolean")
     */
    private $removed;

    /**
     * Get the value of removed
     * @return boolean
     */
    public function getRemoved() {
        return $this->removed;
    }

    /**
     * Set the value of removed
     * @param boolean removed
     * @return self
     */
    public function setRemoved($removed) {
        $this->removed = $removed;

        return $this;
    }


    /**
     * Get the value of Id
    *
    * @return integer
    */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Title
    *
    * @return string
    */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
    *
    * @param string title
    *
    * @return self
    */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Created At
    *
    * @return string
    */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
    *
    * @param string createdAt
    *
    * @return self
    */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of Content
    *
    * @return string
    */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of Content
    *
    * @param string content
    *
    * @return self
    */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

}