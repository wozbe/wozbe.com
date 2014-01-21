<?php

namespace Wozbe\BlogBundle\Controller;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\BlogBundle\Entity\Post;

class FeedController extends Controller
{
    /**
     * @Route("/{_locale}/feed/rss", name="wozbe_feed_rss", defaults={"_format" = "xml"}, requirements={"_locale" = "fr"})
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function indexAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:Post');
        $postList = $postRepository->findPublished();

        $feed = new Feed();

        $channel = new Channel();
        $channel
            ->title("Wozbe")
            ->description("Wozbe réalise vos produits & services Web en tenant compte de vos problématiques & objectifs business.")
            ->url($this->generateUrl('wozbe_blog', array(), UrlGeneratorInterface::ABSOLUTE_URL))
            ->appendTo($feed);

        foreach($postList as $post) {
            $item = new Item();
            $item
                ->title($post->getTitle())
                ->description($post->getDescription())
                ->url($this->generateUrl('wozbe_blog_post', array('slug' => $post->getSlug(), UrlGeneratorInterface::ABSOLUTE_URL)))
                ->appendTo($channel);
        }

        return new Response($feed->render());
    }
}
