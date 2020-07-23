<?php
/**
 * Created by PhpStorm.
 * User: starwox
 * Date: 23/07/2020
 * Time: 23:24
 */

namespace App\Command;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DepartmentCommand extends Command
{

    protected static $defaultName = 'app:create-department';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription("Create a tester department");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dp = new Department();
        $dp->setName("tester");
        $dp->setCapacity(50);

        $this->em->persist($dp);
        $this->em->flush();

        return Command::SUCCESS;
    }

}