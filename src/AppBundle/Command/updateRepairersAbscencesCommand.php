<?php

    namespace Hopital\AppBundle\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class updateRepairersAbscencesCommand extends Command {

        protected function configure () {
            // On set le nom de la commande
            $this->setName('app:update-abscences');

            // On set la description
            $this->setDescription("Permet de mettre à jour la disponibilité des intervenants");

        }

        public function execute (InputInterface $input, OutputInterface $output) {
            $text = "Traitement réalisé";

            $em = $this->getDoctrine()->getManager();
            $abscences = $em->getRepository('HOCompanyBundle:RepairerAbscence')->findAll();

            $today = new \Datetime('now'); 
            foreach ($abscences as $abs) {
                if($abs->getDateBegin()->format('d-m-Y') == $today->format('d-m-Y')){
                    $abs->getRepairer()->setIsActive(false);
                    $em->merge($abs);
                }

                if($abs->getDateEnd()->format('d-m-Y') == $today->format('d-m-Y')){
                    $abs->getRepairer()->setIsActive(false);
                    $em->merge($abs);
                }
                $em->push();
            }


            $output->writeln($text.'!');
        }
    }