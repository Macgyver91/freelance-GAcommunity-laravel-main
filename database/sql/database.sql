-- convert Laravel migrations to raw SQL scripts --
-- SET @ORIG_SQL_REQUIRE_PRIMARY_KEY = @@SQL_REQUIRE_PRIMARY_KEY;
-- SET SQL_REQUIRE_PRIMARY_KEY = 0;

-- migration:2014_10_12_000000_create_users_table --
create table `users` (
  `id` bigint unsigned not null auto_increment primary key, 
  `username` varchar(255) null, 
  `email` varchar(255) not null, 
  `email_verified_at` timestamp null, 
  `password` varchar(255) null, 
  `remember_token` varchar(100) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `users` 
add 
  unique `users_username_unique`(`username`);
alter table 
  `users` 
add 
  unique `users_email_unique`(`email`);

-- migration:2014_10_12_100000_create_password_resets_table --
create table `password_resets` (
  `email` varchar(255) not null, 
  `token` varchar(255) not null, 
  `created_at` timestamp null, 
  `id` bigint unsigned not null auto_increment primary key
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `password_resets` 
add 
  index `password_resets_email_index`(`email`);

-- migration:2019_08_19_000000_create_failed_jobs_table --
create table `failed_jobs` (
  `id` bigint unsigned not null auto_increment primary key, 
  `uuid` varchar(255) not null, 
  `connection` text not null, 
  `queue` text not null, 
  `payload` longtext not null, 
  `exception` longtext not null, 
  `failed_at` timestamp default CURRENT_TIMESTAMP not null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `failed_jobs` 
add 
  unique `failed_jobs_uuid_unique`(`uuid`);

-- migration:2019_12_14_000001_create_personal_access_tokens_table --
create table `personal_access_tokens` (
  `id` bigint unsigned not null auto_increment primary key, 
  `tokenable_type` varchar(255) not null, 
  `tokenable_id` bigint unsigned not null, 
  `name` varchar(255) not null, 
  `token` varchar(64) not null, 
  `abilities` text null, 
  `last_used_at` timestamp null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `personal_access_tokens` 
add 
  index `personal_access_tokens_tokenable_type_tokenable_id_index`(
    `tokenable_type`, `tokenable_id`
  );
alter table 
  `personal_access_tokens` 
add 
  unique `personal_access_tokens_token_unique`(`token`);

-- migration:2021_09_21_081953_create_membres_table --
create table `membres` (
  `id` bigint unsigned not null auto_increment primary key, 
  `status` enum('prospect', 'membre') not null, 
  `info` json not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_09_21_084644_create_prospects_table --
create table `prospects` (
  `id` bigint unsigned not null auto_increment primary key, 
  `nom` varchar(45) not null, 
  `prenom` varchar(45) not null, 
  `email` varchar(255) not null, 
  `tel` int not null, 
  `type` enum('S', 'P', 'C') not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `prospects` 
add 
  unique `prospects_email_unique`(`email`);

-- migration:2021_09_21_085526_create_membre_has_prospects_table --
create table `membre_has_prospects` (
  `id` bigint unsigned not null auto_increment primary key, 
  `membre_id` bigint unsigned not null, 
  `prospect_id` bigint unsigned not null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `membre_has_prospects` 
add 
  constraint `membre_has_prospects_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;
alter table 
  `membre_has_prospects` 
add 
  constraint `membre_has_prospects_prospect_id_foreign` foreign key (`prospect_id`) references `membres` (`id`) on delete cascade;

-- migration:2021_09_21_085949_create_liens_table --
create table `liens` (
  `id` bigint unsigned not null auto_increment primary key, 
  `type` enum(
    'frere/soeur', 'parent/enfant', 'cousin(e)', 
    'oncle/tante'
  ) not null, 
  `membre_id` bigint unsigned not null, 
  `prospect_id` bigint unsigned not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `liens` 
add 
  constraint `liens_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;
alter table 
  `liens` 
add 
  constraint `liens_prospect_id_foreign` foreign key (`prospect_id`) references `membres` (`id`) on delete cascade;

-- migration:2021_09_21_093218_create_passion_metier_talents_table --
create table `passion_metier_talents` (
  `id` bigint unsigned not null auto_increment primary key, 
  `status` enum('P', 'M', 'T') not null, 
  `mot_clefs` varchar(45) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_09_21_095935_create_membre_has_passions_metiers_talents_table --
create table `membre_has_passion_metier_talents` (
  `id` bigint unsigned not null auto_increment primary key, 
  `membre_id` bigint unsigned not null, 
  `passion_metier_talent_id` bigint unsigned null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `membre_has_passion_metier_talents` 
add 
  constraint `membre_has_passion_metier_talents_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;
alter table 
  `membre_has_passion_metier_talents` 
add 
  constraint `pmt_id` foreign key (`passion_metier_talent_id`) references `passion_metier_talents` (`id`) on delete cascade;

-- migration:2021_09_21_101114_create_petit_groupes_table --
create table `petit_groupes` (
  `id` bigint unsigned not null auto_increment primary key, 
  `capitaine` int null, 
  `photo` varchar(255) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_09_21_101532_create_grand_groupes_table --
create table `grand_groupes` (
  `id` bigint unsigned not null auto_increment primary key, 
  `type` enum('N1', 'N2', 'N3', 'N4') not null, 
  `nom` varchar(45) not null, 
  `mantra` varchar(255) not null, 
  `declaration` varchar(255) not null, 
  `photo` varchar(255) not null, 
  `logo` varchar(255) not null, 
  `musique_choree` varchar(255) not null, 
  `video_choree` varchar(255) not null, 
  `photo_drapeau` varchar(255) not null, 
  `capitaine` bigint unsigned null, 
  `co_capitaine` bigint unsigned null, 
  `resp_com` bigint unsigned null, 
  `resp_heritage` bigint unsigned null, 
  `resp_anges` bigint unsigned null, 
  `resp_bateau` bigint unsigned null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_09_21_102556_create_abandons_table --
create table `abandons` (
  `id` bigint unsigned not null auto_increment primary key, 
  `motif` varchar(255) not null, 
  `nb_rate` double(8, 2) not null, 
  `membre_id` bigint unsigned not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `abandons` 
add 
  constraint `abandons_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;

-- migration:2021_09_21_112515_create_evenements_table --
create table `evenements` (
  `id` bigint unsigned not null auto_increment primary key, 
  `type` enum('N1', 'N2', 'N3', 'N4') not null, 
  `numero_week_end` int not null, 
  `pays` enum('France') not null, 
  `ville` varchar(45) not null, 
  `centre` varchar(45) not null, 
  `date_debut` datetime not null, 
  `date_fin` datetime not null, 
  `lieu` varchar(45) not null, 
  `adresse` varchar(255) not null, 
  `coach` varchar(45) not null, 
  `tarif` decimal(15, 2) not null, 
  `membre_id` bigint unsigned not null, 
  `grand_groupe_id` bigint unsigned not null, 
  `abd_membre_id` bigint unsigned null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `evenements` 
add 
  constraint `evenements_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;
alter table 
  `evenements` 
add 
  constraint `evenements_grand_groupe_id_foreign` foreign key (`grand_groupe_id`) references `grand_groupes` (`id`) on delete cascade;

-- migration:2021_09_21_113841_create_staffs_table --
create table `staff_lists` (
  `id` bigint unsigned not null auto_increment primary key, 
  `evenement_id` bigint unsigned null, 
  `event_mem_id` bigint unsigned null, 
  `event_gg_id` bigint unsigned null, 
  `event_abandon_id` bigint unsigned null, 
  `ev_abd_membre_id` bigint unsigned null, 
  `nom` varchar(45) not null, 
  `mantra` varchar(255) not null, 
  `logo` varchar(255) not null, 
  `type` varchar(45) not null, 
  `photo` varchar(255) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `staff_lists` 
add 
  constraint `staff_lists_evenement_id_foreign` foreign key (`evenement_id`) references `evenements` (`id`) on delete cascade;

-- migration:2021_09_21_114959_create_staff_has_membres_table --
create table `staff_membres` (
  `id` bigint unsigned not null auto_increment primary key, 
  `staff_event_id` bigint unsigned null, 
  `stf_mbr_eve_id` bigint unsigned null, 
  `stf_gg_eve_id` bigint unsigned null, 
  `stf_abd_eve_id` bigint unsigned null, 
  `stf_abd_eve_mbr_id` bigint unsigned null, 
  `membre_id` bigint unsigned not null, 
  `staff_list_id` bigint unsigned not null, 
  `commentaire` varchar(255) not null, 
  `taux_de_passage` tinyint not null, 
  `role_du_staff` varchar(45) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `staff_membres` 
add 
  constraint `staff_membres_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;
alter table 
  `staff_membres` 
add 
  constraint `staff_membres_staff_list_id_foreign` foreign key (`staff_list_id`) references `staff_lists` (`id`) on delete cascade;

-- migration:2021_09_21_115632_create_role_du_staffs_table --
create table `role_du_staffs` (
  `id` bigint unsigned not null auto_increment primary key, 
  `nom` varchar(255) not null, 
  `role` json not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_09_21_120017_create_comptabilites_table --
create table `comptabilites` (
  `id` bigint unsigned not null auto_increment primary key, 
  `evenement_id` bigint unsigned not null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `comptabilites` 
add 
  constraint `comptabilites_evenement_id_foreign` foreign key (`evenement_id`) references `evenements` (`id`) on delete cascade;

-- migration:2021_09_21_120343_create_depense_recettes_table --
create table `depense_recettes` (
  `id` bigint unsigned not null auto_increment primary key, 
  `type` enum('D', 'R') not null, 
  `nom` varchar(45) not null, 
  `categorie` varchar(255) not null, 
  `montant` int not null, 
  `date` datetime not null, 
  `facture_devis` varchar(255) not null, 
  `responsable` int not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_09_21_120829_create_comptabilite_has_depense_recettes_table --
create table `comptabilite_has_depense_recettes` (
  `id` bigint unsigned not null auto_increment primary key, 
  `comptabilite_id` bigint unsigned not null, 
  `depense_recette_id` bigint unsigned not null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `comptabilite_has_depense_recettes` 
add 
  constraint `comptabilite_has_depense_recettes_comptabilite_id_foreign` foreign key (`comptabilite_id`) references `comptabilites` (`id`) on delete cascade;
alter table 
  `comptabilite_has_depense_recettes` 
add 
  constraint `comptabilite_has_depense_recettes_depense_recette_id_foreign` foreign key (`depense_recette_id`) references `depense_recettes` (`id`) on delete cascade;

-- migration:2021_10_18_062724_create_define_passwords_table --
create table `define_passwords` (
  `email` varchar(255) not null, 
  `token` varchar(255) not null, 
  `created_at` timestamp null, 
  `id` bigint unsigned not null auto_increment primary key
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `define_passwords` 
add 
  index `define_passwords_email_index`(`email`);

-- migration:2021_10_21_065117_create_evenement_membres_table --
create table `evenement_membres` (
  `id` bigint unsigned not null auto_increment primary key, 
  `membre_id` bigint unsigned not null, 
  `evenement_id` bigint unsigned not null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `evenement_membres` 
add 
  constraint `evenement_membres_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;
alter table 
  `evenement_membres` 
add 
  constraint `evenement_membres_evenement_id_foreign` foreign key (`evenement_id`) references `evenements` (`id`) on delete cascade;

-- migration:2021_10_22_063928_update_evenements_table --
ALTER TABLE 
  evenements CHANGE membre_id membre_id BIGINT UNSIGNED DEFAULT NULL, 
  CHANGE grand_groupe_id grand_groupe_id BIGINT UNSIGNED DEFAULT NULL, 
  CHANGE abd_membre_id abd_membre_id BIGINT UNSIGNED DEFAULT NULL;

-- migration:2021_10_22_090110_update_abandons_table --
alter table 
  `abandons` 
add 
  `evenement_id` bigint unsigned not null;
alter table 
  `abandons` 
add 
  constraint `abandons_evenement_id_foreign` foreign key (`evenement_id`) references `evenements` (`id`) on delete cascade;

-- migration:2021_10_25_081329_update_petit_groupe_relation --
alter table 
  `petit_groupes` 
add 
  `grand_groupe_id` bigint unsigned not null;
alter table 
  `petit_groupes` 
add 
  constraint `petit_groupes_grand_groupe_id_foreign` foreign key (`grand_groupe_id`) references `grand_groupes` (`id`) on delete cascade;

-- migration:2021_10_25_081542_create_petit_groupe_membres_table --
create table `petit_groupe_membres` (
  `id` bigint unsigned not null auto_increment primary key, 
  `petit_groupe_id` bigint unsigned not null, 
  `membre_id` bigint unsigned not null, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `petit_groupe_membres` 
add 
  constraint `petit_groupe_membres_petit_groupe_id_foreign` foreign key (`petit_groupe_id`) references `petit_groupes` (`id`) on delete cascade;
alter table 
  `petit_groupe_membres` 
add 
  constraint `petit_groupe_membres_membre_id_foreign` foreign key (`membre_id`) references `membres` (`id`) on delete cascade;

-- migration:2021_10_25_143935_add_role_user_id_to_users_table --
alter table 
  `users` 
add 
  `nom` varchar(255) null, 
add 
  `prenom` varchar(255) null;

-- migration:2021_10_27_102537_create_permission_tables --
create table `permissions` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) not null, 
  `guard_name` varchar(255) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `permissions` 
add 
  unique `permissions_name_guard_name_unique`(`name`, `guard_name`);
create table `roles` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) not null, 
  `guard_name` varchar(255) not null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `roles` 
add 
  unique `roles_name_guard_name_unique`(`name`, `guard_name`);
-- SET 
--   SESSION sql_require_primary_key=1;
create table `model_has_permissions` (
  `permission_id` bigint unsigned not null, 
  `model_type` varchar(255) not null, 
  `model_id` bigint unsigned not null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `model_has_permissions` 
add 
  index `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`);
alter table 
  `model_has_permissions` 
add 
  constraint `model_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade;
alter table 
  `model_has_permissions` 
add 
  primary key `model_has_permissions_permission_model_type_primary`(
    `permission_id`, `model_id`, `model_type`
  );
create table `model_has_roles` (
  `role_id` bigint unsigned not null, 
  `model_type` varchar(255) not null, 
  `model_id` bigint unsigned not null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `model_has_roles` 
add 
  index `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`);
alter table 
  `model_has_roles` 
add 
  constraint `model_has_roles_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade;
alter table 
  `model_has_roles` 
add 
  primary key `model_has_roles_role_model_type_primary`(
    `role_id`, `model_id`, `model_type`
  );
create table `role_has_permissions` (
  `permission_id` bigint unsigned not null, 
  `role_id` bigint unsigned not null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `role_has_permissions` 
add 
  constraint `role_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade;
alter table 
  `role_has_permissions` 
add 
  constraint `role_has_permissions_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade;
alter table 
  `role_has_permissions` 
add 
  primary key `role_has_permissions_permission_id_role_id_primary`(`permission_id`, `role_id`);

-- migration:2021_10_29_080752_create_type_liens_table --
create table `type_liens` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2021_10_29_082840_add_foreign_key_liens --
alter table 
  `liens` 
add 
  `type_lien_id` bigint unsigned not null;
alter table 
  `liens` 
add 
  constraint `liens_type_lien_id_foreign` foreign key (`type_lien_id`) references `type_liens` (`id`) on delete cascade;
alter table 
  `liens` 
drop 
  `type`;

-- migration:2021_11_03_111348_create_ange_invitation_table --
create table `ange_invitation` (
  `id` bigint unsigned not null auto_increment primary key, 
  `created_at` timestamp null, `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
