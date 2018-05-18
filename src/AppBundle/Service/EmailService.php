<?php
namespace AppBundle\Service;

use AppBundle\Entity\ContatoInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailService {

    private $mailer;
    private $templating;

    /**
     * @param Request $mailer;
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function enviarContato(ContatoInterface $entity, $from, $to, $cc)
    {
        $message = \Swift_Message::newInstance();
            $imgUrl = $message->embed(\Swift_Image::fromPath($entity->getImage()));
            $message
            ->setSubject($entity->getAssunto())
                ->setFrom($from)
            ->setTo($to)
            ->setCc($cc)
            ->setBody(
                $this->templating->render(
                    'AppBundle:Emails:contato.html.twig',
                    [
                        'nome' => $entity->getNome(),
                        'email' => $entity->getEmail(),
                        'mensagem' => $entity->getMensagem(),
                        'telefone' => $entity->getTelefone(),
                        'url' => $imgUrl,
                        'assunto' => $entity->getAssunto()
                    ]
                ),
                'text/html'
            );

        return $message;
    }

}