<?php

namespace Training\Seller\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Seller\Api\SellerRepositoryInterface;

class GetCommand extends Command
{
    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    const ID_OPTION = "id";

    /**
     * @param SellerRepositoryInterface $sellerRepository
     */
    public function __construct(SellerRepositoryInterface $sellerRepository) {
        $this->sellerRepository = $sellerRepository;
        parent::__construct(null);
    }

    /**
     * Initialization of the command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('training:seller:get')
            ->setDescription('Display seller info')
            ->setDefinition(
                [
                    new InputOption(
                        self::ID_OPTION,
                        '-i',
                        InputOption::VALUE_REQUIRED,
                        'Seller id'
                    )
                ]
            );

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getOption(self::ID_OPTION);
        if(is_null($id)) {
            throw new \InvalidArgumentException("Argument " . self::ID_OPTION . " is missing.");
        }

        $seller = $this->sellerRepository->getById($id);

        $output->writeln("<error>" . $seller->getName() . "</error>");
    }
}
