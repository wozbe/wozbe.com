<?php

namespace Wozbe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}/blog", name="wozbe_blog", requirements={"_locale" = "fr"}, options={"sitemap" = true})
     * @Template()
     */
    public function indexAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:Post');
        
        return array(
            'posts' => $postRepository->findAll()
        );
        
        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@WozbeBlogBundle/Resources/posts/');
        
        $finder = new Finder();
        $finder->files()->in($path);
        
        $posts = array ();
        
        $titleNormalizer = function ($path) {
            preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2}-(.*)\.md$#', $path, $matches);
            
            return str_replace('-', ' ', $matches[1]);
        };
        
        $slugNormalizer = function ($path) {
            return str_replace('.md', '', $path);
        };

        foreach ($finder as $file) {
            $posts[] = array(
                'title' => $titleNormalizer($file->getFilename()),
                'slug' => $slugNormalizer($file->getFilename()),
            );
        }
        
        return array(
            'posts' => $posts,
        );
    }
    
    /**
     * @Route("/{_locale}/blog/{slug}", name="wozbe_blog_post", requirements={"_locale" = "fr"}, options={"sitemap" = true})
     * @Template()
     */
    public function postAction($slug)
    {
        $postRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:Post');
        $commentRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:Comment');
        
        $post = $postRepository->findOneBy(array('slug' => $slug));
        $comments = $commentRepository->findByPost($post);
        
        $post_content = str_replace('{{ site.url }}', 'http://localhost/Wozbe/bundles/wozbeblog/', $post->getContent());
        
        return array(
            'post_content' => $post->getContent(),
            'comments' => $comments,
            'slug' => $slug,
        );
    }
}
