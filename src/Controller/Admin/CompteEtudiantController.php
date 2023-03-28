<?php

namespace App\Controller\Admin;

use App\Entity\CompteEtudiant;
use App\Entity\Etudiant;
use App\Form\CompteEtudiantType;
use App\Repository\CompteEtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/compte_etudiant')]
class CompteEtudiantController extends AbstractController {

    #[Route('/', name: 'app_compte_etudiant_index', methods: ['GET'])]
    public function index(CompteEtudiantRepository $compteEtudiantRepository): Response {
        return $this->render('Admin/fusionEtudiantCompte/index.html.twig', [
            'compte_etudiants' => $compteEtudiantRepository->findAll(),
        ]);

    }

    #[Route('/test', name: 'app_compte_etudiant_index_test', methods: ['GET'])]
    public function index2(CompteEtudiantRepository $compteEtudiantRepository): Response {
        return $this->render('Admin/compte_etudiant/index.html.twig', [
            'compte_etudiants' => $compteEtudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_compte_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompteEtudiantRepository $compteEtudiantRepository,
            UserPasswordHasherInterface $passwordHasher): Response {
        $compteEtudiant = new CompteEtudiant();
        $form = $this->createForm(CompteEtudiantType::class, $compteEtudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($compteEtudiant, $compteEtudiant->getPassword());
            $compteEtudiant->setPassword($hashedPassword);
            $compteEtudiant->setRoles([$form['role']->getData()]);
            $compteEtudiantRepository->save($compteEtudiant, true);
            return $this->redirectToRoute('app_compte_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/fusionEtudiantCompte/new.html.twig', [
                    'compte_etudiant' => $compteEtudiant,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compte_etudiant_show', methods: ['GET'])]
    public function show(CompteEtudiant $compteEtudiant): Response {
        return $this->render('Admin/fusionEtudiantCompte/show.html.twig', [
                    'compte_etudiant' => $compteEtudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_compte_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompteEtudiant $compteEtudiant,
            CompteEtudiantRepository $compteEtudiantRepository,
            UserPasswordHasherInterface $passwordHasher): Response {

        $oldPassword = $compteEtudiant->getPassword();

        $form = $this->createForm(CompteEtudiantType::class, $compteEtudiant);
        $form['role']->setData($compteEtudiant->getRoles()[0]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Ne change que le mot de passe si le champs n'est pas vide
            if ($compteEtudiant->getPassword() == "no change"){
                $compteEtudiant->setPassword($oldPassword);
            }
            else{
                $hashedPassword = $passwordHasher->hashPassword($compteEtudiant, $compteEtudiant->getPassword());
                $compteEtudiant->setPassword($hashedPassword);
            }
            $compteEtudiant->setRoles([$form['role']->getData()]);
            $compteEtudiantRepository->save($compteEtudiant, true);

            return $this->redirectToRoute('app_compte_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/compte_etudiant/edit.html.twig', [
                    'compte_etudiant' => $compteEtudiant,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compte_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, CompteEtudiant $compteEtudiant, CompteEtudiantRepository $compteEtudiantRepository): Response {
        if ($this->isCsrfTokenValid('delete' . $compteEtudiant->getId(), $request->request->get('_token'))) {
            $compteEtudiantRepository->remove($compteEtudiant, true);
        }

        return $this->redirectToRoute('app_compte_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }

}
