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
        $kernel = $this->get('kernel');
        
        try {
            $path = $kernel->locateResource(sprintf('@WozbeBlogBundle/Resources/posts/%s.md', $slug));
        }
        catch(\InvalidArgumentException $e) {
            throw $this->createNotFoundException(sprintf('Blog post "%s" not found', $slug));
        }
        
        $post_content = file_get_contents($path);
        $post_content = str_replace('{{ site.url }}', 'http://localhost/Wozbe/bundles/wozbeblog/', $post_content);
        
        
        return array(
            'post_content' => $post_content,
            'slug' => $slug,
        );
    }
}
