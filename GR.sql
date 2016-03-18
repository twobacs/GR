-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 18 Mars 2016 à 11:27
-- Version du serveur: 5.5.47-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `polimo`
--

-- --------------------------------------------------------

--
-- Structure de la table `armes`
--

CREATE TABLE IF NOT EXISTS `armes` (
  `num_arme` varchar(20) NOT NULL,
  `dateLivraison` date NOT NULL,
  `calibre` varchar(10) NOT NULL,
  `validite_arme` date NOT NULL,
  `marque_arme` varchar(20) NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  `type` varchar(1) NOT NULL,
  `id_user` int(4) NOT NULL,
  `coffre` varchar(1) DEFAULT 'O',
  PRIMARY KEY (`num_arme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(6) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(3) NOT NULL,
  `denomination` varchar(50) NOT NULL,
  `id_fournisseur` int(4) NOT NULL,
  `stock` int(4) NOT NULL,
  `commentaire` varchar(300) NOT NULL,
  `id_mesure` int(2) NOT NULL,
  `prix_achat` float(10,0) NOT NULL,
  `q_min` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_article`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `article_taille`
--

CREATE TABLE IF NOT EXISTS `article_taille` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_article` int(6) NOT NULL,
  `taille` varchar(100) CHARACTER SET utf8 NOT NULL,
  `stock` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `batons`
--

CREATE TABLE IF NOT EXISTS `batons` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_baton` varchar(30) NOT NULL,
  `marque_baton` varchar(40) NOT NULL,
  `disponible` varchar(1) NOT NULL,
  `id_user` int(4) NOT NULL DEFAULT '0',
  `dateLivraison` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `num_baton` (`num_baton`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Structure de la table `brassards`
--

CREATE TABLE IF NOT EXISTS `brassards` (
  `num_brassard` varchar(20) NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  `id_user` int(4) NOT NULL,
  `dateLivraison` date NOT NULL,
  PRIMARY KEY (`num_brassard`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `calibre`
--

CREATE TABLE IF NOT EXISTS `calibre` (
  `calibre` varchar(10) NOT NULL,
  PRIMARY KEY (`calibre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `casiers`
--

CREATE TABLE IF NOT EXISTS `casiers` (
  `num_casier` varchar(4) NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  PRIMARY KEY (`num_casier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categories_articles`
--

CREATE TABLE IF NOT EXISTS `categories_articles` (
  `id_categorie` int(3) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zip` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2851 ;

-- --------------------------------------------------------

--
-- Structure de la table `commandeClient`
--

CREATE TABLE IF NOT EXISTS `commandeClient` (
  `id_comClient` int(8) NOT NULL AUTO_INCREMENT,
  `id_user` int(4) NOT NULL,
  `id_article` int(6) NOT NULL,
  `quantite` int(2) NOT NULL,
  `den_statut` varchar(15) NOT NULL,
  `encode` varchar(1) NOT NULL DEFAULT 'N',
  `commentaire` varchar(100) NOT NULL,
  `essai` int(1) NOT NULL,
  `date_commande` date NOT NULL,
  `date_acceptation` date NOT NULL,
  `date_livraison` date NOT NULL,
  PRIMARY KEY (`id_comClient`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=249 ;

-- --------------------------------------------------------

--
-- Structure de la table `commandeFournisseur`
--

CREATE TABLE IF NOT EXISTS `commandeFournisseur` (
  `id_comFourn` int(5) NOT NULL AUTO_INCREMENT,
  `nom_fourn` varchar(50) NOT NULL,
  `id_article` int(6) NOT NULL,
  `commentaire` varchar(100) NOT NULL,
  `quantite` int(6) NOT NULL,
  `ref_fourn` varchar(50) NOT NULL,
  `den_statut` varchar(15) NOT NULL,
  `date_commande` date NOT NULL,
  `date_reception` date NOT NULL,
  PRIMARY KEY (`id_comFourn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Structure de la table `documents_articles`
--

CREATE TABLE IF NOT EXISTS `documents_articles` (
  `id_doc` int(5) NOT NULL AUTO_INCREMENT,
  `id_article` int(5) NOT NULL,
  `nom_doc` varchar(50) NOT NULL,
  `nom_fichier` varchar(36) NOT NULL,
  PRIMARY KEY (`id_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id_fournisseur` int(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `num_entreprise` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `numero` varchar(8) DEFAULT NULL,
  `CP` varchar(8) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `actif` varchar(1) DEFAULT 'O',
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `denomination_grade` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `grh_droits`
--

CREATE TABLE IF NOT EXISTS `grh_droits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app` varchar(32) NOT NULL,
  `id_user` int(4) NOT NULL,
  `niv_acces` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_controlemedical`
--

CREATE TABLE IF NOT EXISTS `gr_controlemedical` (
  `id_controlemedical` int(11) NOT NULL AUTO_INCREMENT,
  `denomination_controle` varchar(200) NOT NULL,
  PRIMARY KEY (`id_controlemedical`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_evaluation`
--

CREATE TABLE IF NOT EXISTS `gr_evaluation` (
  `id_evaluation` int(11) NOT NULL AUTO_INCREMENT,
  `denomination_evaluation` varchar(200) NOT NULL,
  `date_entretienprep` date NOT NULL,
  `date_evaluation` date NOT NULL,
  `rapport_fonctionnement` varchar(200) NOT NULL,
  PRIMARY KEY (`id_evaluation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_fonction`
--

CREATE TABLE IF NOT EXISTS `gr_fonction` (
  `id_profil` int(11) NOT NULL AUTO_INCREMENT,
  `denomination_profil` varchar(200) NOT NULL,
  `liendoc` varchar(300) NOT NULL,
  `id_evaluation` int(11) NOT NULL,
  PRIMARY KEY (`id_profil`),
  KEY `id_evaluation` (`id_evaluation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_fonctioncontrolemedicale`
--

CREATE TABLE IF NOT EXISTS `gr_fonctioncontrolemedicale` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_controlemedicale` int(11) NOT NULL,
  `id_profil` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_fonctionformation`
--

CREATE TABLE IF NOT EXISTS `gr_fonctionformation` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_formation` int(11) NOT NULL,
  `id_profil` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_fonctionrisque`
--

CREATE TABLE IF NOT EXISTS `gr_fonctionrisque` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_risque` int(11) NOT NULL,
  `id_profil` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_fonctionusers`
--

CREATE TABLE IF NOT EXISTS `gr_fonctionusers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_profil` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_formation`
--

CREATE TABLE IF NOT EXISTS `gr_formation` (
  `id_formation` int(11) NOT NULL AUTO_INCREMENT,
  `denomination_formation` varchar(200) NOT NULL,
  `duree_formation` int(200) NOT NULL,
  `date_formation` date NOT NULL,
  `type_formation` varchar(200) NOT NULL,
  PRIMARY KEY (`id_formation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `gr_risque`
--

CREATE TABLE IF NOT EXISTS `gr_risque` (
  `id_risque` int(11) NOT NULL AUTO_INCREMENT,
  `denomination_risque` varchar(200) NOT NULL,
  PRIMARY KEY (`id_risque`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `histo_arme`
--

CREATE TABLE IF NOT EXISTS `histo_arme` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_arme` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `dateA` date NOT NULL,
  `motifA` varchar(200) NOT NULL,
  `dateR` date NOT NULL,
  `motifR` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Structure de la table `histo_baton`
--

CREATE TABLE IF NOT EXISTS `histo_baton` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_baton` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `dateA` date NOT NULL,
  `motifA` varchar(200) NOT NULL,
  `dateR` date NOT NULL,
  `motifR` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `histo_brassard`
--

CREATE TABLE IF NOT EXISTS `histo_brassard` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_brassard` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `dateA` date NOT NULL,
  `motifA` varchar(200) NOT NULL,
  `dateR` date NOT NULL,
  `motifR` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `histo_radio`
--

CREATE TABLE IF NOT EXISTS `histo_radio` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_TEI` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `dateA` date NOT NULL,
  `motifA` varchar(200) NOT NULL,
  `dateR` date NOT NULL,
  `motifR` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `h_liberation`
--

CREATE TABLE IF NOT EXISTS `h_liberation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFK` int(5) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `naissance` varchar(10) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `debut` varchar(10) NOT NULL,
  `fin` varchar(10) NOT NULL,
  `conditions` varchar(200) NOT NULL,
  `typeliberation` varchar(70) NOT NULL,
  `quartier` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Structure de la table `liste_rues`
--

CREATE TABLE IF NOT EXISTS `liste_rues` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `islp_Cle` varchar(9) CHARACTER SET utf8 NOT NULL,
  `islp_Rue` longtext CHARACTER SET utf8 NOT NULL,
  `islp_Commune` varchar(20) CHARACTER SET utf8 NOT NULL,
  `islp_Commissariat` varchar(20) CHARACTER SET utf8 NOT NULL,
  `islp_Quartier` varchar(2) CHARACTER SET utf8 NOT NULL,
  `multi_ID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `multi_L_LAXON` varchar(50) CHARACTER SET utf8 NOT NULL,
  `multi_L_ADDRID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `spw_Cle` varchar(10) CHARACTER SET utf8 NOT NULL,
  `spw_CP` int(4) NOT NULL,
  `spw_Anc_Comm` varchar(20) CHARACTER SET utf8 NOT NULL,
  `spw_Code_RegNat` varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=684 ;

-- --------------------------------------------------------

--
-- Structure de la table `marque_arme`
--

CREATE TABLE IF NOT EXISTS `marque_arme` (
  `marque_arme` varchar(20) NOT NULL,
  PRIMARY KEY (`marque_arme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marque_baton`
--

CREATE TABLE IF NOT EXISTS `marque_baton` (
  `marque_baton` varchar(40) NOT NULL,
  PRIMARY KEY (`marque_baton`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marque_radio`
--

CREATE TABLE IF NOT EXISTS `marque_radio` (
  `marque_radio` varchar(20) NOT NULL,
  PRIMARY KEY (`marque_radio`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marque_transAcces`
--

CREATE TABLE IF NOT EXISTS `marque_transAcces` (
  `marque_transAcces` varchar(20) NOT NULL,
  PRIMARY KEY (`marque_transAcces`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marque_transCles`
--

CREATE TABLE IF NOT EXISTS `marque_transCles` (
  `marque_transCles` varchar(25) NOT NULL,
  PRIMARY KEY (`marque_transCles`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE IF NOT EXISTS `materiel` (
  `id_materiels` int(11) NOT NULL AUTO_INCREMENT,
  `den_matos` varchar(250) NOT NULL,
  PRIMARY KEY (`id_materiels`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `mat_fichier`
--

CREATE TABLE IF NOT EXISTS `mat_fichier` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `type_obj` varchar(32) NOT NULL,
  `id_obj` varchar(20) NOT NULL,
  `nom_fichier` varchar(50) NOT NULL,
  `type_doc` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Structure de la table `mob_batiment`
--

CREATE TABLE IF NOT EXISTS `mob_batiment` (
  `id_mobBat` int(3) NOT NULL AUTO_INCREMENT,
  `denom_mobBat` varchar(100) NOT NULL,
  `desc_mobBat` varchar(200) NOT NULL,
  PRIMARY KEY (`id_mobBat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `mob_categorie`
--

CREATE TABLE IF NOT EXISTS `mob_categorie` (
  `id_mobCateg` int(3) NOT NULL AUTO_INCREMENT,
  `desc_mobCateg` varchar(200) NOT NULL,
  `denom_mobCateg` varchar(100) NOT NULL,
  PRIMARY KEY (`id_mobCateg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `mob_histo`
--

CREATE TABLE IF NOT EXISTS `mob_histo` (
  `id_mobHisto` int(10) NOT NULL AUTO_INCREMENT,
  `id_mobMat` varchar(7) NOT NULL,
  `id_mobLoc` int(3) NOT NULL,
  `date_attribMob` date NOT NULL,
  `date_retraitMob` date NOT NULL,
  PRIMARY KEY (`id_mobHisto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `mob_local`
--

CREATE TABLE IF NOT EXISTS `mob_local` (
  `id_mobLocal` int(3) NOT NULL AUTO_INCREMENT,
  `denom_mobLocal` varchar(100) NOT NULL,
  `desc_mobLocal` varchar(200) NOT NULL,
  `id_mobBat` int(3) NOT NULL,
  PRIMARY KEY (`id_mobLocal`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `mob_materiel`
--

CREATE TABLE IF NOT EXISTS `mob_materiel` (
  `id_mobMat` varchar(7) NOT NULL,
  `denom_mobMat` varchar(100) NOT NULL,
  `id_mobCateg` int(3) NOT NULL,
  `desc_mobMat` varchar(200) NOT NULL,
  `dateAchat_mobMat` date NOT NULL,
  `attribue` varchar(1) NOT NULL DEFAULT 'N',
  `dateSortie_mobMat` date NOT NULL,
  PRIMARY KEY (`id_mobMat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `motifs_objet`
--

CREATE TABLE IF NOT EXISTS `motifs_objet` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `objet` varchar(15) NOT NULL,
  `motif` varchar(10) NOT NULL,
  `cause` varchar(80) NOT NULL,
  `dispo` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_user` int(4) NOT NULL,
  `id_article` int(6) NOT NULL,
  `quantite` int(2) NOT NULL,
  `actif` varchar(1) NOT NULL DEFAULT 'O',
  `essai` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Structure de la table `pannes`
--

CREATE TABLE IF NOT EXISTS `pannes` (
  `id_panne` int(5) NOT NULL AUTO_INCREMENT,
  `typeMat` varchar(30) NOT NULL,
  `numMat` varchar(30) NOT NULL,
  `description` varchar(300) NOT NULL,
  `datePanne` date NOT NULL,
  `dateDepotSAV` date NOT NULL,
  `dateRetourSAV` date NOT NULL,
  PRIMARY KEY (`id_panne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `nom` varchar(25) NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Structure de la table `pers_contact`
--

CREATE TABLE IF NOT EXISTS `pers_contact` (
  `id_contact` int(8) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `CodePost` varchar(8) NOT NULL,
  `Commune` varchar(50) NOT NULL,
  `Rue` varchar(100) NOT NULL,
  `Numero` varchar(5) DEFAULT NULL,
  `Tf` varchar(20) DEFAULT NULL,
  `GSM` varchar(20) DEFAULT NULL,
  `Parente` varchar(20) DEFAULT NULL,
  `Prior` int(1) DEFAULT NULL,
  `id_user` int(4) NOT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `PF_Article`
--

CREATE TABLE IF NOT EXISTS `PF_Article` (
  `id_PFArticle` int(5) NOT NULL AUTO_INCREMENT,
  `denom_PFArticle` varchar(50) NOT NULL,
  `id_fourn` int(3) NOT NULL,
  `stock_PFArticle` int(4) NOT NULL,
  `stockMini_PFArticle` int(4) NOT NULL,
  `id_PFUMesure` int(2) NOT NULL,
  `desc_PFArticle` varchar(300) NOT NULL,
  `id_PFCateg` int(3) NOT NULL,
  PRIMARY KEY (`id_PFArticle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `PF_Categ`
--

CREATE TABLE IF NOT EXISTS `PF_Categ` (
  `id_PFCateg` int(3) NOT NULL AUTO_INCREMENT,
  `denom_PFCateg` varchar(30) NOT NULL,
  PRIMARY KEY (`id_PFCateg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Structure de la table `PF_Histo`
--

CREATE TABLE IF NOT EXISTS `PF_Histo` (
  `id_PFHisto` int(10) NOT NULL AUTO_INCREMENT,
  `id_PFArticle` int(5) NOT NULL,
  `quantite` int(5) NOT NULL,
  `id_user_dest` int(4) NOT NULL,
  `id_sv_dest` int(2) NOT NULL,
  `id_user_log` int(4) NOT NULL,
  `date_Attrib` date NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id_PFHisto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Structure de la table `PF_UMesure`
--

CREATE TABLE IF NOT EXISTS `PF_UMesure` (
  `id_PFUMesure` int(2) NOT NULL AUTO_INCREMENT,
  `denom_PFUMesure` varchar(30) NOT NULL,
  PRIMARY KEY (`id_PFUMesure`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `photos_articles`
--

CREATE TABLE IF NOT EXISTS `photos_articles` (
  `id_photo` int(6) NOT NULL AUTO_INCREMENT,
  `id_article` int(5) NOT NULL,
  `nom_fichier` varchar(36) NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `pret_categorie`
--

CREATE TABLE IF NOT EXISTS `pret_categorie` (
  `id_pretCateg` int(3) NOT NULL AUTO_INCREMENT,
  `denom_pretCateg` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pretCateg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `pret_histo`
--

CREATE TABLE IF NOT EXISTS `pret_histo` (
  `id_pretHisto` int(100) NOT NULL AUTO_INCREMENT,
  `id_pretMat` int(3) NOT NULL,
  `dateSortie_pretMat` date NOT NULL DEFAULT '0000-00-00',
  `dateRetourPrevu_pretMat` date NOT NULL DEFAULT '0000-00-00',
  `dateRetourEffectif_pretMat` date NOT NULL,
  `id_user` int(4) NOT NULL,
  `id_respLog` int(4) NOT NULL,
  `rappel_mail` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_pretHisto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `pret_materiel`
--

CREATE TABLE IF NOT EXISTS `pret_materiel` (
  `id_pretMat` int(3) NOT NULL AUTO_INCREMENT,
  `id_pretCateg` int(3) NOT NULL,
  `denom_pretMat` varchar(100) NOT NULL,
  `statut_pretMat` varchar(1) NOT NULL DEFAULT 'D',
  PRIMARY KEY (`id_pretMat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Structure de la table `radios`
--

CREATE TABLE IF NOT EXISTS `radios` (
  `num_TEI` varchar(20) NOT NULL,
  `num_ISSI` int(7) NOT NULL,
  `dateLivraison` date NOT NULL,
  `statut` varchar(20) NOT NULL,
  `marque_radio` varchar(20) NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  `id_user` int(4) NOT NULL,
  PRIMARY KEY (`num_TEI`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rues_mouscron`
--

CREATE TABLE IF NOT EXISTS `rues_mouscron` (
  `id_rue` int(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `CP` int(4) NOT NULL,
  `carte1` int(3) NOT NULL,
  `carte2` int(3) NOT NULL,
  `carte3` int(3) NOT NULL,
  `carte4` int(3) NOT NULL,
  PRIMARY KEY (`id_rue`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=719 ;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id_service` int(2) NOT NULL AUTO_INCREMENT,
  `denomination_service` varchar(50) NOT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `sexe`
--

CREATE TABLE IF NOT EXISTS `sexe` (
  `denomination` varchar(8) NOT NULL,
  PRIMARY KEY (`denomination`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE IF NOT EXISTS `statut` (
  `den_statut` varchar(15) NOT NULL,
  PRIMARY KEY (`den_statut`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tailles`
--

CREATE TABLE IF NOT EXISTS `tailles` (
  `taille` varchar(100) NOT NULL,
  PRIMARY KEY (`taille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `matricule` int(9) NOT NULL,
  `nom` longtext CHARACTER SET utf8 NOT NULL,
  `prenom` longtext CHARACTER SET utf8 NOT NULL,
  `password` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tel_appareil`
--

CREATE TABLE IF NOT EXISTS `tel_appareil` (
  `id_appareil` int(4) NOT NULL AUTO_INCREMENT,
  `denom_app` varchar(50) NOT NULL,
  `num_serie` varchar(50) NOT NULL,
  `marque_appareil` varchar(50) NOT NULL,
  `date_achat` date NOT NULL DEFAULT '0000-00-00',
  `id_categ` int(2) NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  PRIMARY KEY (`id_appareil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `tel_app_user`
--

CREATE TABLE IF NOT EXISTS `tel_app_user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_appareil` int(4) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL DEFAULT '0000-00-00',
  `date_retour` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `tel_categ_app`
--

CREATE TABLE IF NOT EXISTS `tel_categ_app` (
  `id_categ` int(2) NOT NULL AUTO_INCREMENT,
  `denom_categ` varchar(30) NOT NULL,
  PRIMARY KEY (`id_categ`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `tel_SIM`
--

CREATE TABLE IF NOT EXISTS `tel_SIM` (
  `num_SIM` varchar(25) NOT NULL,
  `num_appel` varchar(25) NOT NULL DEFAULT 'Aucun',
  `num_PUK` int(10) NOT NULL,
  `num_PUK2` int(10) NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  PRIMARY KEY (`num_SIM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tel_SIM_user`
--

CREATE TABLE IF NOT EXISTS `tel_SIM_user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_SIM` varchar(25) NOT NULL,
  `id_user` varchar(4) NOT NULL,
  `date_attrib` date NOT NULL DEFAULT '0000-00-00',
  `date_retour` date NOT NULL DEFAULT '0000-00-00',
  `sim_forfait` int(4) NOT NULL DEFAULT '0',
  `commentaire` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Structure de la table `transpondeursAcces`
--

CREATE TABLE IF NOT EXISTS `transpondeursAcces` (
  `num_transAcces` varchar(20) NOT NULL,
  `marque_transAcces` varchar(20) NOT NULL,
  `dateLivraison` date NOT NULL,
  `disponible` varchar(1) NOT NULL,
  PRIMARY KEY (`num_transAcces`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transpondeursCles`
--

CREATE TABLE IF NOT EXISTS `transpondeursCles` (
  `num_transCles` varchar(20) CHARACTER SET latin1 NOT NULL,
  `dateLivraison` date NOT NULL,
  `disponible` varchar(1) NOT NULL DEFAULT 'O',
  `marque_transCles` varchar(25) NOT NULL,
  PRIMARY KEY (`num_transCles`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `type_user`
--

CREATE TABLE IF NOT EXISTS `type_user` (
  `id_type_user` int(2) NOT NULL,
  `denomination_type_user` varchar(20) NOT NULL,
  PRIMARY KEY (`id_type_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `unite_mesure`
--

CREATE TABLE IF NOT EXISTS `unite_mesure` (
  `id_uMesure` int(2) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(50) NOT NULL,
  PRIMARY KEY (`id_uMesure`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `matricule` int(10) NOT NULL,
  `lateralite` varchar(8) NOT NULL,
  `uniformise` varchar(1) NOT NULL,
  `denomination_sexe` varchar(8) NOT NULL,
  `denomination_grade` varchar(50) NOT NULL,
  `mdp_user` varchar(32) NOT NULL,
  `id_type_user` int(2) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `id_service` int(2) NOT NULL,
  `points` int(10) NOT NULL DEFAULT '0',
  `actif` varchar(1) NOT NULL DEFAULT 'O',
  `log_error` int(1) NOT NULL DEFAULT '0',
  `id_evaluation` int(11) NOT NULL,
  `fixe` varchar(15) NOT NULL,
  `gsm` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `CP` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `rue` varchar(100) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `naissance` date NOT NULL,
  `rrn` varchar(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=261 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_article`
--

CREATE TABLE IF NOT EXISTS `user_article` (
  `idRow` int(5) NOT NULL AUTO_INCREMENT,
  `id_user` int(4) NOT NULL,
  `id_article` int(5) NOT NULL,
  `quantite` int(5) NOT NULL,
  `date_demande` date DEFAULT NULL,
  `motif_demande` varchar(300) DEFAULT NULL,
  `date_avis_log` date DEFAULT NULL,
  `motif_avis_log` varchar(300) DEFAULT NULL,
  `id_log_avis` int(3) DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `id_log_livraison` int(3) DEFAULT NULL,
  PRIMARY KEY (`idRow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_baton`
--

CREATE TABLE IF NOT EXISTS `user_baton` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_baton` varchar(25) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_brassard`
--

CREATE TABLE IF NOT EXISTS `user_brassard` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_brassard` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_casier`
--

CREATE TABLE IF NOT EXISTS `user_casier` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_casier` varchar(4) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_radio`
--

CREATE TABLE IF NOT EXISTS `user_radio` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_TEI` varchar(25) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_transAcces`
--

CREATE TABLE IF NOT EXISTS `user_transAcces` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_transAcces` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_transCles`
--

CREATE TABLE IF NOT EXISTS `user_transCles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `num_transCles` varchar(20) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_attrib` date NOT NULL,
  `date_retour` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_agent_quartier`
--

CREATE TABLE IF NOT EXISTS `z_agent_quartier` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_quartier` int(11) NOT NULL,
  `id_user` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_antenne_quartier`
--

CREATE TABLE IF NOT EXISTS `z_antenne_quartier` (
  `id_antenne` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(300) NOT NULL,
  `IdRue` int(11) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `id_resp` int(4) NOT NULL,
  PRIMARY KEY (`id_antenne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_applis`
--

CREATE TABLE IF NOT EXISTS `z_applis` (
  `id_app` int(2) NOT NULL,
  `nom_app` varchar(50) NOT NULL,
  `description_app` varchar(200) NOT NULL,
  PRIMARY KEY (`id_app`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_bs`
--

CREATE TABLE IF NOT EXISTS `z_bs` (
  `id_bs` varchar(32) NOT NULL,
  `date_heure_in` datetime NOT NULL,
  `date_heure_out` datetime NOT NULL,
  `id_patrouille` varchar(32) NOT NULL,
  `app_photo` varchar(5) NOT NULL DEFAULT 'Aucun',
  `ctrlPers` varchar(3) NOT NULL DEFAULT '0',
  `ctrlVV` varchar(3) NOT NULL DEFAULT '0',
  `vvFouille` varchar(3) NOT NULL,
  `arrestAdm` varchar(3) NOT NULL,
  `arrestJud` varchar(3) NOT NULL,
  `OC` varchar(3) NOT NULL,
  `BCS` varchar(3) NOT NULL,
  `fuguesDisp` varchar(3) NOT NULL,
  `AI` varchar(3) NOT NULL,
  `pvRgp` varchar(3) NOT NULL,
  `rebellion` varchar(3) NOT NULL,
  `pvArmes` varchar(3) NOT NULL,
  `pvStups` varchar(3) NOT NULL,
  `pvOutrages` varchar(3) NOT NULL,
  `pvIvresse` varchar(3) NOT NULL,
  `pvCoups` varchar(3) NOT NULL,
  `pvVol` varchar(3) NOT NULL,
  `pvDiffFamssCoups` varchar(3) NOT NULL,
  `pvDiffFamAvecCoups` varchar(3) NOT NULL,
  `pvDegradations` varchar(3) NOT NULL,
  `pvTapagePart` varchar(3) NOT NULL,
  `pvTapageEts` varchar(3) NOT NULL,
  `pvJudAutres` varchar(3) NOT NULL,
  `pvAccident` varchar(3) NOT NULL,
  `amiable` varchar(3) NOT NULL,
  `vitVvCtrl` varchar(3) NOT NULL,
  `vitPVPI` varchar(3) NOT NULL,
  `vitRetraits` varchar(3) NOT NULL,
  `defAss` varchar(3) NOT NULL,
  `defImm` varchar(3) NOT NULL,
  `defCT` varchar(3) NOT NULL,
  `defAssImCT` varchar(3) NOT NULL,
  `defAssIm` varchar(3) NOT NULL,
  `defImmCT` varchar(3) NOT NULL,
  `defPC` varchar(3) NOT NULL,
  `pvaAssur` varchar(3) NOT NULL,
  `pvaPC` varchar(3) NOT NULL,
  `pvaCI` varchar(3) NOT NULL,
  `pvaExtTrBoite` varchar(3) NOT NULL,
  `pvaPneus` varchar(3) NOT NULL,
  `pvaCT` varchar(3) NOT NULL,
  `pvaIm` varchar(3) NOT NULL,
  `cycloNbCtrl` varchar(3) NOT NULL,
  `cycloNonConforme` varchar(3) NOT NULL,
  `cycloVitNCDefAss` varchar(3) NOT NULL,
  `cycloDefAss` varchar(3) NOT NULL,
  `cycloPlaqueJaune` varchar(3) NOT NULL,
  `cycloAutres` varchar(3) NOT NULL,
  `cycloEnlSaisies` varchar(3) NOT NULL,
  `pipvTrottoir` varchar(3) NOT NULL,
  `pipvZChargt` varchar(3) NOT NULL,
  `pipvBus` varchar(3) NOT NULL,
  `pipvPMR` varchar(3) NOT NULL,
  `pipvPisteCycl` varchar(3) NOT NULL,
  `pipvPassPietons` varchar(3) NOT NULL,
  `pipvE1` varchar(3) NOT NULL,
  `pipvE3` varchar(3) NOT NULL,
  `pipvGSM` varchar(3) NOT NULL,
  `pipvCeinture` varchar(3) NOT NULL,
  `pipvCasque` varchar(3) NOT NULL,
  `pipvC1` varchar(3) NOT NULL,
  `pipvStop` varchar(3) NOT NULL,
  `pipvOrange` varchar(3) NOT NULL,
  `pipvRouge` varchar(3) NOT NULL,
  `pipvGenant` varchar(3) NOT NULL,
  `alcoVVCtrl` varchar(3) NOT NULL,
  `alcoPersCtrl` varchar(3) NOT NULL,
  `alcoA` varchar(3) NOT NULL,
  `alcoP` varchar(3) NOT NULL,
  `alcoRetraits` varchar(3) NOT NULL,
  `alcoPds` varchar(3) NOT NULL,
  `alcoStups` varchar(3) NOT NULL,
  `alcoSuiteAcc` varchar(3) NOT NULL,
  `plNbrCtrl` varchar(3) NOT NULL,
  `plPI` varchar(3) NOT NULL,
  `plPV` varchar(3) NOT NULL,
  `plNbrAdr` varchar(3) NOT NULL,
  `plPIAdr` varchar(3) NOT NULL,
  `plPVAdr` varchar(3) NOT NULL,
  `printed` varchar(1) NOT NULL DEFAULT 'N',
  `PVRoulAutre` varchar(3) NOT NULL,
  `PVAAutre` varchar(3) NOT NULL,
  `pipvAutre` varchar(3) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id_bs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_bs_armeCollec`
--

CREATE TABLE IF NOT EXISTS `z_bs_armeCollec` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_bs` varchar(32) NOT NULL,
  `id_arme` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_bs_ETT`
--

CREATE TABLE IF NOT EXISTS `z_bs_ETT` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_ETT` varchar(50) NOT NULL,
  `id_bs` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=499 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_bs_GSM`
--

CREATE TABLE IF NOT EXISTS `z_bs_GSM` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_bs` varchar(32) NOT NULL,
  `id_GSM` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_bs_users`
--

CREATE TABLE IF NOT EXISTS `z_bs_users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_bs` varchar(32) NOT NULL,
  `id_user` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1184 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_bs_vv`
--

CREATE TABLE IF NOT EXISTS `z_bs_vv` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_bs` varchar(32) NOT NULL,
  `immatriculation` varchar(10) NOT NULL,
  `plein` varchar(1) NOT NULL DEFAULT 'N',
  `degats` varchar(300) NOT NULL DEFAULT 'N&eacute;ant',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=473 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_categorie_fiche`
--

CREATE TABLE IF NOT EXISTS `z_categorie_fiche` (
  `id_categ` int(11) NOT NULL AUTO_INCREMENT,
  `id_section` int(11) NOT NULL,
  `denomination` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categ`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_commerce`
--

CREATE TABLE IF NOT EXISTS `z_commerce` (
  `id_commerce` varchar(32) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `ville` varchar(300) NOT NULL,
  `CP` varchar(10) NOT NULL,
  `idRue` int(11) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `descriptif` varchar(300) NOT NULL,
  PRIMARY KEY (`id_commerce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_denom_equipe`
--

CREATE TABLE IF NOT EXISTS `z_denom_equipe` (
  `id_denomination` int(4) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(100) NOT NULL,
  PRIMARY KEY (`id_denomination`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_ETT`
--

CREATE TABLE IF NOT EXISTS `z_ETT` (
  `id_ETT` varchar(50) NOT NULL,
  `date_validite` date NOT NULL,
  `dateLivraison` date NOT NULL,
  `dateSortie` date NOT NULL,
  `marque` varchar(30) NOT NULL,
  `modele` varchar(30) NOT NULL,
  PRIMARY KEY (`id_ETT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche`
--

CREATE TABLE IF NOT EXISTS `z_fiche` (
  `id_fiche` varchar(13) NOT NULL,
  `id_categ` int(11) NOT NULL,
  `dateHr_encodage` datetime NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `interaction` varchar(1) NOT NULL DEFAULT 'N',
  `id_encodeur` int(4) NOT NULL,
  `texteInfo` varchar(300) NOT NULL,
  PRIMARY KEY (`id_fiche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche_commerce`
--

CREATE TABLE IF NOT EXISTS `z_fiche_commerce` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_fiche` varchar(13) NOT NULL,
  `id_commerce` varchar(32) NOT NULL,
  `id_liaison` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche_lieudit`
--

CREATE TABLE IF NOT EXISTS `z_fiche_lieudit` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_fiche` varchar(13) NOT NULL,
  `id_lieudit` varchar(32) NOT NULL,
  `id_liaison` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche_personne`
--

CREATE TABLE IF NOT EXISTS `z_fiche_personne` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_fiche` varchar(13) NOT NULL,
  `id_personne` int(11) NOT NULL,
  `id_liaison` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche_photo`
--

CREATE TABLE IF NOT EXISTS `z_fiche_photo` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_fiche` varchar(13) NOT NULL,
  `id_photo` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche_textelibre`
--

CREATE TABLE IF NOT EXISTS `z_fiche_textelibre` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_fiche` varchar(13) NOT NULL,
  `id_textelibre` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=200 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_fiche_vehicule`
--

CREATE TABLE IF NOT EXISTS `z_fiche_vehicule` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_fiche` varchar(13) NOT NULL,
  `id_vehicule` varchar(32) NOT NULL,
  `id_liaison` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=153 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_fonctionnalites`
--

CREATE TABLE IF NOT EXISTS `z_fonctionnalites` (
  `id_fonctionnalite` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(300) NOT NULL,
  PRIMARY KEY (`id_fonctionnalite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_garde`
--

CREATE TABLE IF NOT EXISTS `z_garde` (
  `id_garde` int(3) NOT NULL AUTO_INCREMENT,
  `id_svGarde` int(3) NOT NULL,
  `dateHr_debut` datetime NOT NULL,
  `dateHr_fin` datetime NOT NULL,
  `id_garde_sv_pers` int(5) NOT NULL,
  PRIMARY KEY (`id_garde`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_garde_sv_pers`
--

CREATE TABLE IF NOT EXISTS `z_garde_sv_pers` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_svGarde` int(3) NOT NULL,
  `id_type_pers_garde` varchar(2) NOT NULL,
  `id_pers` int(3) NOT NULL DEFAULT '-1',
  `id_user` int(3) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_garde_type_pers`
--

CREATE TABLE IF NOT EXISTS `z_garde_type_pers` (
  `id_type_pers_garde` varchar(2) NOT NULL,
  `denomination` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type_pers_garde`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_GSM`
--

CREATE TABLE IF NOT EXISTS `z_GSM` (
  `num_GSM` varchar(50) NOT NULL,
  PRIMARY KEY (`num_GSM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_indic`
--

CREATE TABLE IF NOT EXISTS `z_indic` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `demandes_habitation` varchar(20) NOT NULL,
  `demandeurs_habitation` varchar(42) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1255 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_info_push`
--

CREATE TABLE IF NOT EXISTS `z_info_push` (
  `id_info` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(4) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `info` varchar(2000) NOT NULL,
  `dateIn` date NOT NULL,
  `valid` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_info`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_info_user`
--

CREATE TABLE IF NOT EXISTS `z_info_user` (
  `id_ligne` int(6) NOT NULL AUTO_INCREMENT,
  `id_info` int(4) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_lecture` date NOT NULL,
  PRIMARY KEY (`id_ligne`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_intervention`
--

CREATE TABLE IF NOT EXISTS `z_intervention` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_patrouille` varchar(32) NOT NULL,
  `num_fiche` varchar(32) NOT NULL,
  `dh_avis` datetime NOT NULL,
  `coord_avis` varchar(300) NOT NULL,
  `dh_surplace` datetime NOT NULL,
  `coord_surplace` varchar(300) NOT NULL,
  `dh_fin` datetime NOT NULL,
  `coord_fin` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1653 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_liaison`
--

CREATE TABLE IF NOT EXISTS `z_liaison` (
  `id_liaison` int(11) NOT NULL DEFAULT '0',
  `denomination` varchar(100) NOT NULL,
  PRIMARY KEY (`id_liaison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_lieudit`
--

CREATE TABLE IF NOT EXISTS `z_lieudit` (
  `id_lieudit` varchar(32) NOT NULL,
  `description` varchar(300) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  PRIMARY KEY (`id_lieudit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_lieu_mission`
--

CREATE TABLE IF NOT EXISTS `z_lieu_mission` (
  `id_lieu` int(5) NOT NULL AUTO_INCREMENT,
  `nom_lieu` varchar(300) NOT NULL,
  PRIMARY KEY (`id_lieu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_localite`
--

CREATE TABLE IF NOT EXISTS `z_localite` (
  `id_loc` int(11) NOT NULL AUTO_INCREMENT,
  `code_poste` varchar(10) NOT NULL,
  `localite` varchar(300) NOT NULL,
  `pays` varchar(300) NOT NULL,
  PRIMARY KEY (`id_loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_logs`
--

CREATE TABLE IF NOT EXISTS `z_logs` (
  `id_log` int(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(4) NOT NULL,
  `ip_user` varchar(30) NOT NULL,
  `date_in` date NOT NULL,
  `heure_in` varchar(5) NOT NULL,
  `date_out` date NOT NULL,
  `heure_out` varchar(5) NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3445 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_missions`
--

CREATE TABLE IF NOT EXISTS `z_missions` (
  `id_mission` int(5) NOT NULL AUTO_INCREMENT,
  `nom_mission` varchar(100) NOT NULL,
  `code_mission` varchar(3) NOT NULL,
  PRIMARY KEY (`id_mission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_niv_acces`
--

CREATE TABLE IF NOT EXISTS `z_niv_acces` (
  `id_nivAcces` int(2) NOT NULL,
  `denom_nivAcces` varchar(50) NOT NULL,
  `desc_nivAcces` varchar(200) NOT NULL,
  PRIMARY KEY (`id_nivAcces`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_patrouille`
--

CREATE TABLE IF NOT EXISTS `z_patrouille` (
  `id_patrouille` varchar(32) NOT NULL,
  `date_heure_debut` datetime NOT NULL,
  `date_heure_fin` datetime NOT NULL,
  `indicatif` varchar(50) NOT NULL,
  `denomination` varchar(200) NOT NULL,
  `actif` varchar(1) NOT NULL,
  `id_prestation` int(11) NOT NULL,
  PRIMARY KEY (`id_patrouille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_pat_missions`
--

CREATE TABLE IF NOT EXISTS `z_pat_missions` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_patrouille` varchar(32) NOT NULL,
  `type_mission` varchar(20) NOT NULL,
  `id_fiche` varchar(13) NOT NULL,
  `date_heure_in` datetime NOT NULL,
  `date_heure_out` datetime NOT NULL,
  `commentaire` varchar(500) NOT NULL DEFAULT 'Aucun',
  `lieu` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5723 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_personne`
--

CREATE TABLE IF NOT EXISTS `z_personne` (
  `id_personne` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL DEFAULT '0000-00-00',
  `photo` varchar(300) NOT NULL DEFAULT 'none',
  `pays` varchar(100) NOT NULL,
  `ville` varchar(300) NOT NULL,
  `CP` varchar(10) NOT NULL,
  `adresse` varchar(300) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `descriptif` varchar(300) NOT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=245 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_pers_garde`
--

CREATE TABLE IF NOT EXISTS `z_pers_garde` (
  `id_pers` int(3) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `fixe` varchar(15) NOT NULL,
  `gsm` varchar(15) NOT NULL,
  `CP` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `rue` varchar(100) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `mail` varchar(200) NOT NULL,
  PRIMARY KEY (`id_pers`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_photo`
--

CREATE TABLE IF NOT EXISTS `z_photo` (
  `id_photo` varchar(32) NOT NULL,
  `commentaire` varchar(300) NOT NULL,
  `lien` varchar(300) NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_prestations`
--

CREATE TABLE IF NOT EXISTS `z_prestations` (
  `id_prestation` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(300) NOT NULL,
  `id_fonctionnalite` int(11) NOT NULL,
  `descriptif` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_prestation`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_quartier`
--

CREATE TABLE IF NOT EXISTS `z_quartier` (
  `id_quartier` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(300) NOT NULL,
  `id_antenne` int(11) NOT NULL,
  `gsm` varchar(30) NOT NULL,
  PRIMARY KEY (`id_quartier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_quartier_rue`
--

CREATE TABLE IF NOT EXISTS `z_quartier_rue` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_quartier` int(11) NOT NULL,
  `IdRue` int(11) NOT NULL,
  `cote` varchar(1) NOT NULL,
  `limiteBas` varchar(11) NOT NULL,
  `limiteHaut` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1345 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_rues`
--

CREATE TABLE IF NOT EXISTS `z_rues` (
  `IdRue` int(11) NOT NULL AUTO_INCREMENT,
  `NomRue` varchar(50) DEFAULT NULL,
  `StraatNaam` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IdRue`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=660 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_rue_loc`
--

CREATE TABLE IF NOT EXISTS `z_rue_loc` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_loc` int(11) NOT NULL,
  `IdRue` int(11) NOT NULL,
  `cote` varchar(1) NOT NULL,
  `limiteBas` varchar(11) NOT NULL,
  `limiteHaut` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_section_fiche`
--

CREATE TABLE IF NOT EXISTS `z_section_fiche` (
  `id_section` int(11) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(100) NOT NULL,
  PRIMARY KEY (`id_section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_sv_garde`
--

CREATE TABLE IF NOT EXISTS `z_sv_garde` (
  `id_svGarde` int(3) NOT NULL AUTO_INCREMENT,
  `id_typeGarde` int(3) NOT NULL,
  `denomination_svGarde` varchar(50) NOT NULL,
  PRIMARY KEY (`id_svGarde`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_texte_libre`
--

CREATE TABLE IF NOT EXISTS `z_texte_libre` (
  `id_textelibre` varchar(32) NOT NULL,
  `texte` text NOT NULL,
  `titre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_textelibre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_type_garde`
--

CREATE TABLE IF NOT EXISTS `z_type_garde` (
  `id_typeGarde` int(3) NOT NULL AUTO_INCREMENT,
  `denomination` varchar(30) NOT NULL,
  PRIMARY KEY (`id_typeGarde`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_user_app`
--

CREATE TABLE IF NOT EXISTS `z_user_app` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_app` int(2) NOT NULL,
  `id_user` int(4) NOT NULL,
  `id_nivAcces` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=306 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_contact`
--

CREATE TABLE IF NOT EXISTS `z_vac_contact` (
  `id_contact` varchar(32) NOT NULL,
  `nom_contact` varchar(50) NOT NULL,
  `prenom_contact` varchar(50) NOT NULL,
  `adresse_contact` varchar(300) NOT NULL,
  `numero_contact` varchar(6) NOT NULL,
  `CP_contact` int(6) NOT NULL,
  `ville_contact` varchar(50) NOT NULL,
  `tel_contact` varchar(25) NOT NULL,
  `tel2_contact` varchar(25) NOT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_demandeur`
--

CREATE TABLE IF NOT EXISTS `z_vac_demandeur` (
  `id_dem` varchar(32) NOT NULL,
  `nom_dem` varchar(50) NOT NULL,
  `prenom_dem` varchar(50) NOT NULL,
  `dn_dem` date NOT NULL,
  `tel_dem` varchar(25) NOT NULL,
  `gsm_dem` varchar(25) NOT NULL,
  `mail_dem` varchar(200) NOT NULL,
  PRIMARY KEY (`id_dem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_habitation`
--

CREATE TABLE IF NOT EXISTS `z_vac_habitation` (
  `id_vac` int(10) NOT NULL AUTO_INCREMENT,
  `id_dem` varchar(32) NOT NULL,
  `IdRue` int(11) NOT NULL,
  `vac_numero` varchar(10) NOT NULL,
  `vac_CP` int(6) NOT NULL,
  `vac_ville` varchar(50) NOT NULL,
  `vac_dateDemande` date NOT NULL,
  `vac_dateDepart` date NOT NULL,
  `vac_dateRetour` date NOT NULL,
  `vac_destination` text NOT NULL,
  `vac_contSP` varchar(300) NOT NULL,
  `vac_GDP` varchar(1) NOT NULL,
  `vac_nbFacades` int(2) NOT NULL,
  `vac_alarme` varchar(1) NOT NULL,
  `vac_eclairageExt` varchar(1) NOT NULL,
  `vac_eclairageInt` varchar(1) NOT NULL,
  `vac_chien` varchar(1) NOT NULL,
  `vac_courrier` varchar(1) NOT NULL,
  `vac_persCourrier` varchar(100) NOT NULL,
  `vac_persAuto` varchar(1) NOT NULL,
  `vac_persPers` varchar(100) NOT NULL,
  `vac_dateVisiteTechno` date NOT NULL,
  `vac_remarque` text NOT NULL,
  `vac_gmap` varchar(250) NOT NULL,
  `vac_CR` varchar(1) NOT NULL DEFAULT 'N',
  `vac_date_CR` date NOT NULL,
  PRIMARY KEY (`id_vac`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=784 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_hab_cont`
--

CREATE TABLE IF NOT EXISTS `z_vac_hab_cont` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_vac` int(10) NOT NULL,
  `id_contact` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1045 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_hab_controle`
--

CREATE TABLE IF NOT EXISTS `z_vac_hab_controle` (
  `id_controle` int(10) NOT NULL AUTO_INCREMENT,
  `id_vac` int(10) NOT NULL,
  `id_user` int(4) NOT NULL,
  `date_heure` datetime NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `resultat` varchar(8) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id_controle`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3632 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_hab_vv`
--

CREATE TABLE IF NOT EXISTS `z_vac_hab_vv` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_vac` int(10) NOT NULL,
  `id_vv` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=508 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_vac_vv`
--

CREATE TABLE IF NOT EXISTS `z_vac_vv` (
  `id_vv` int(4) NOT NULL AUTO_INCREMENT,
  `marque_vv` varchar(50) NOT NULL,
  `imm_vv` varchar(10) NOT NULL,
  `lieu_vv` varchar(100) NOT NULL,
  PRIMARY KEY (`id_vv`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=598 ;

-- --------------------------------------------------------

--
-- Structure de la table `z_vehicule`
--

CREATE TABLE IF NOT EXISTS `z_vehicule` (
  `id_vv` varchar(32) NOT NULL,
  `marque` varchar(100) NOT NULL,
  `modele` varchar(100) NOT NULL,
  `immatriculation` varchar(30) NOT NULL,
  `chassis` varchar(30) NOT NULL,
  `couleur` varchar(100) NOT NULL,
  `descriptif` varchar(300) NOT NULL,
  PRIMARY KEY (`id_vv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `z_vv_zp`
--

CREATE TABLE IF NOT EXISTS `z_vv_zp` (
  `immatriculation` varchar(10) NOT NULL,
  `modele` varchar(100) NOT NULL,
  PRIMARY KEY (`immatriculation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
