<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\GroupeMusicaux;
use App\Form\GroupMusicauxType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GroupeMusicauxRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/api', name: 'app_api')]
class ApiController extends AbstractController
{

	/**
	 * return all register data of import file
	 */
	#[Route(path: '/import-file', name: 'app_import')]
	public function importFile(
		Request $request,
		SerializerInterface $serializer,
		EntityManagerInterface $entityManager
	) {
		$uploadedFile = $request->files->get('excelFile');

		if ($uploadedFile) {
			if ($uploadedFile->getClientOriginalExtension() === 'xls' || $uploadedFile->getClientOriginalExtension() === 'xlsx') {
				$spreadsheet = IOFactory::load($uploadedFile->getRealPath());
				$worksheet = $spreadsheet->getActiveSheet();
				$data = $worksheet->toArray();

				// Supprime la première ligne (en-têtes de colonne)
				array_shift($data);

				foreach ($data as $row) {
					$origine = $row[1];
					$ville = $row[2];
					$fondateurs = $row[5];

					// Vérification des données existent
					$existingEntry = $entityManager->getRepository(GroupeMusicaux::class)->findOneBy([
						'origine' => $origine,
						'ville' => $ville,
						'fondateurs' => $fondateurs,
					]);

					// Si l'entrée n'existe pas déjà,on l' enregistre
					if (!$existingEntry) {
						$groupMusicaux = new GroupeMusicaux();
						$groupMusicaux->setOrigine($row[1]);
						$groupMusicaux->setVille($row[2]);
						$groupMusicaux->setAnneeDebut((int)$row[3]);
						$groupMusicaux->setAnneSeparation((int)$row[4]);
						$groupMusicaux->setFondateurs($row[5]);
						$groupMusicaux->setMembres((int)$row[6]);
						$groupMusicaux->setCourantMusical($row[7]);
						$groupMusicaux->setPresentation($row[8]);

						$entityManager->persist($groupMusicaux);
					}
				}

				$entityManager->flush();

				$jsonData = $serializer->serialize($data, 'json');
				return new Response($jsonData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
			} else {
				return new Response('Le fichier doit être au format XLS ou XLSX.', Response::HTTP_BAD_REQUEST);
			}
		}

		return new Response('Aucun fichier n\'a été téléchargé.', Response::HTTP_BAD_REQUEST);
	}


	/**
	 * return all Groups
	 */
	#[Route(path: '/groups', name: 'app_api_groups')]
	public function getGroups(
		GroupeMusicauxRepository $presenceRepository,
		SerializerInterface $serializer
	) {

		return new Response(
			$serializer->serialize($presenceRepository->findAll(), 'json'),
			200,
			['Content-Type' => 'application/json']
		);
	}

	/**
	 * update Groups
	 */
	#[Route(path: '/update/{id}', name: 'app_api_update')]
	public function updateGroupMusicaux(GroupeMusicaux $groupMusicaux, Request $request, EntityManagerInterface $entityManager)
	{

		if (!$groupMusicaux) {
			return new JsonResponse(["message" => "L'enregistrement n'a pas été trouvé."], 404);
		}


		// Vérifier les champs de la demande et les mettre à jour si présents
		if ($request->get('origine')) {
			$groupMusicaux->setOrigine($request->get('origine'));
		}
		if ($request->get('ville')) {
			$groupMusicaux->setVille($request->get('ville'));
		}
		if ($request->get('anneeDebut')) {
			$groupMusicaux->setAnneeDebut($request->get('anneeDebut'));
		}
		if ($request->get('anneeSeparation')) {
			$groupMusicaux->setAnneSeparation($request->get('anneeSeparation'));
		}
		if ($request->get('fondateurs')) {
			$groupMusicaux->setFondateurs($request->get('fondateurs'));
		}
		if ($request->get('membres')) {
			$groupMusicaux->setMembres($request->get('membres'));
		}
		if ($request->get('courantMusical')) {
			$groupMusicaux->setCourantMusical($request->get('courantMusical'));
		}
		if ($request->get('presentation')) {
			$groupMusicaux->setPresentation($request->get('presentation'));
		}

		try {
			$entityManager->flush();
			return new JsonResponse(['message' => 'L\'enregistrement a été mis à jour avec succès.'], 200);
		} catch (\Exception $e) {
			return new JsonResponse(['message' => 'Erreur lors de la mise à jour de l\'enregistrement.'], 500);
		}
	}

	/**
	 * delete Groups
	 */
	#[Route(path: '/delete/{id}', name: 'app_api_delete')]
	public function deleteGroupMusicaux(GroupeMusicaux $groupMusicaux, EntityManagerInterface $entityManager)
	{
		if (!$groupMusicaux) {
			return new JsonResponse(['message' => 'L\'enregistrement n\'a pas été trouvé.'], 404);
		}

		$entityManager->remove($groupMusicaux);
		$entityManager->flush();

		return new JsonResponse(['message' => 'L\'enregistrement a été supprimé avec succès.'], 200);
	}
}
