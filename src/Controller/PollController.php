<?php
namespace App\Controller;

use App\Entity\Poll;
use App\Repository\PollRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\IsNull;

/**
 * @Route("/api/poll")
 */
class PollController extends AbstractController
{
    /**
     * @Route("/", name="get_poll", methods={"GET"})
     */
	#[Route("/poll", name:"get_poll" )]
    public function getPoll( EntityManagerInterface $em ): JsonResponse
    {
        // Retrieve the poll from the database, you can customize this as needed
        $poll = $em->getRepository(Poll::class)->getLatestVote();

        return $this->json($poll);
    }

    /**
     * @Route("/vote/{choice}", name="vote_poll", methods={"POST"})
     */
	#[Route("/vote/{choice}", name:"vote_poll" )]
    public function votePoll(string $choice, EntityManagerInterface $em, PollRepository $pollRepository  ): JsonResponse
    {
		$poll = new Poll();
		$latestPoll = $pollRepository->getLatestVote();

        if ($choice === 'yes') {
            $poll->setYesCount($latestPoll->getYesCount() + 1);
			$poll->setNoCount($latestPoll->getNoCount());
        } elseif ($choice === 'no') {
            $poll->setNoCount($latestPoll->getNoCount() + 1);
			$poll->setYesCount($latestPoll->getYesCount() );

        } else {
            throw $this->createNotFoundException('Invalid choice');
        }

		$em->persist($poll);
		$em->flush();

        return $this->json(['message' => 'Vote recorded']);
    }
}
