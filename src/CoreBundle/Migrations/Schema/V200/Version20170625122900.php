<?php

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Migrations\Schema\V200;

use Chamilo\CoreBundle\Entity\ExtraField;
use Chamilo\CoreBundle\Migrations\AbstractMigrationChamilo;
use Chamilo\CourseBundle\Entity\CSurvey;
use Doctrine\DBAL\Schema\Schema;

class Version20170625122900 extends AbstractMigrationChamilo
{
    public function up(Schema $schema): void
    {
        if (false === $schema->hasTable('resource_comment')) {
            $this->addSql(
                'CREATE TABLE IF NOT EXISTS resource_comment (id INT AUTO_INCREMENT NOT NULL, resource_node_id INT DEFAULT NULL, author_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, root INT DEFAULT NULL, lvl INT NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, INDEX IDX_C9D4B5841BAD783F (resource_node_id), INDEX IDX_C9D4B584F675F31B (author_id), INDEX IDX_C9D4B584727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
            );
            $this->addSql(
                'ALTER TABLE resource_comment ADD CONSTRAINT FK_C9D4B5841BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id) ON DELETE SET NULL;'
            );
            $this->addSql(
                'ALTER TABLE resource_comment ADD CONSTRAINT FK_C9D4B584F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE SET NULL;'
            );
            $this->addSql(
                'ALTER TABLE resource_comment ADD CONSTRAINT FK_C9D4B584727ACA70 FOREIGN KEY (parent_id) REFERENCES resource_comment (id) ON DELETE CASCADE;'
            );

        }


        $this->addSql('CREATE TABLE IF NOT EXISTS resource_tag (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_23D039CAF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC;');

        $this->addSql('CREATE TABLE IF NOT EXISTS resource_user_tag (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_46131CA5A76ED395 (user_id), INDEX IDX_46131CA5BAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC;');

        $this->addSql('CREATE TABLE IF NOT EXISTS personal_file (id INT AUTO_INCREMENT NOT NULL, resource_node_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BD95312D1BAD783F (resource_node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC;');

        $this->addSql(
            'CREATE TABLE IF NOT EXISTS tool_resource_right (id INT AUTO_INCREMENT NOT NULL, tool_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, mask INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS resource_link (id INT AUTO_INCREMENT NOT NULL, resource_node_id INT DEFAULT NULL, session_id INT DEFAULT NULL, user_id INT DEFAULT NULL, c_id INT DEFAULT NULL, group_id INT DEFAULT NULL, usergroup_id INT DEFAULT NULL, visibility INT NOT NULL, start_visibility_at DATETIME DEFAULT NULL, end_visibility_at DATETIME DEFAULT NULL, INDEX IDX_398C394B1BAD783F (resource_node_id), INDEX IDX_398C394B613FECDF (session_id), INDEX IDX_398C394BA76ED395 (user_id), INDEX IDX_398C394B91D79BD3 (c_id), INDEX IDX_398C394BFE54D947 (group_id), INDEX IDX_398C394BD2112630 (usergroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS resource_right (id INT AUTO_INCREMENT NOT NULL, resource_link_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, mask INT NOT NULL, INDEX IDX_9F710F26F004E599 (resource_link_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS resource_node (id INT AUTO_INCREMENT NOT NULL, resource_type_id INT NOT NULL, resource_file_id INT DEFAULT NULL, creator_id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, level INT DEFAULT NULL, path VARCHAR(3000) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8A5F48FF98EC6B7B (resource_type_id), UNIQUE INDEX UNIQ_8A5F48FFCE6B9E84 (resource_file_id), INDEX IDX_8A5F48FF61220EA6 (creator_id), INDEX IDX_8A5F48FF727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS resource_type (id INT AUTO_INCREMENT NOT NULL, tool_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_83FEF7938F7B22CC (tool_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS resource_file (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size INT NOT NULL, media_id INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_83BF96AAEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
        );

        $table = $schema->getTable('resource_link');
        if (false === $table->hasForeignKey('FK_398C394B1BAD783F')) {
            $this->addSql(
                'ALTER TABLE resource_link ADD CONSTRAINT FK_398C394B1BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id);'
            );
        }
        if (false === $table->hasForeignKey('FK_398C394B613FECDF')) {
            $this->addSql(
                'ALTER TABLE resource_link ADD CONSTRAINT FK_398C394B613FECDF FOREIGN KEY (session_id) REFERENCES session (id);'
            );
        }
        if (false === $table->hasForeignKey('FK_398C394BA76ED395')) {
            $this->addSql(
                'ALTER TABLE resource_link ADD CONSTRAINT FK_398C394BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id);'
            );
        }
        if (false === $table->hasForeignKey('FK_398C394B91D79BD3')) {
            $this->addSql(
                'ALTER TABLE resource_link ADD CONSTRAINT FK_398C394B91D79BD3 FOREIGN KEY (c_id) REFERENCES course (id);'
            );
        }
        if (false === $table->hasForeignKey('FK_398C394BFE54D947')) {
            $this->addSql(
                'ALTER TABLE resource_link ADD CONSTRAINT FK_398C394BFE54D947 FOREIGN KEY (group_id) REFERENCES c_group_info (iid);'
            );
        }
        if (false === $table->hasForeignKey('FK_398C394BD2112630')) {
            $this->addSql(
                'ALTER TABLE resource_link ADD CONSTRAINT FK_398C394BD2112630 FOREIGN KEY (usergroup_id) REFERENCES usergroup (id);'
            );
        }

        $table = $schema->getTable('resource_right');
        if (false === $table->hasForeignKey('FK_9F710F26F004E599')) {
            $this->addSql(
                'ALTER TABLE resource_right ADD CONSTRAINT FK_9F710F26F004E599 FOREIGN KEY (resource_link_id) REFERENCES resource_link (id);'
            );
        }

        $table = $schema->getTable('resource_node');
        if (false === $table->hasForeignKey('FK_8A5F48FF98EC6B7B')) {
            $this->addSql(
                'ALTER TABLE resource_node ADD CONSTRAINT FK_8A5F48FF98EC6B7B FOREIGN KEY (resource_type_id) REFERENCES resource_type (id);'
            );
        }
        if (false === $table->hasForeignKey('FK_8A5F48FFCE6B9E84')) {
            $this->addSql(
                'ALTER TABLE resource_node ADD CONSTRAINT FK_8A5F48FFCE6B9E84 FOREIGN KEY (resource_file_id) REFERENCES resource_file (id);'
            );
        }
        if (false === $table->hasForeignKey('FK_8A5F48FF61220EA6')) {
            $this->addSql(
                'ALTER TABLE resource_node ADD CONSTRAINT FK_8A5F48FF61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id) ON DELETE CASCADE;'
            );
        }
        if (false === $table->hasForeignKey('FK_8A5F48FF727ACA70')) {
            $this->addSql(
                'ALTER TABLE resource_node ADD CONSTRAINT FK_8A5F48FF727ACA70 FOREIGN KEY (parent_id) REFERENCES resource_node (id) ON DELETE CASCADE;'
            );
        }

        $table = $schema->getTable('resource_type');
        if (false === $table->hasForeignKey('FK_83FEF7938F7B22CC')) {
            $this->addSql(
                'ALTER TABLE resource_type ADD CONSTRAINT FK_83FEF7938F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id);'
            );
        }

        /*$table = $schema->getTable('resource_type');
        if (false === $table->hasForeignKey('FK_83BF96AAEA9FDD75')) {
            $this->addSql(
                'ALTER TABLE resource_file ADD CONSTRAINT FK_83BF96AAEA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id);'
            );
        }*/

        $table = $schema->getTable('tool_resource_right');
        if (false === $table->hasForeignKey('FK_E5C562598F7B22CC')) {
            $this->addSql(
                'ALTER TABLE tool_resource_right ADD CONSTRAINT FK_E5C562598F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id);'
            );
        }

        $table = $schema->getTable('c_document');
        if (false === $table->hasColumn('resource_node_id')) {
            $this->addSql('ALTER TABLE c_document ADD resource_node_id INT DEFAULT NULL');
            $this->addSql(
                'ALTER TABLE c_document ADD CONSTRAINT FK_C9FA0CBD1BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id);'
            );
            $this->addSql('CREATE UNIQUE INDEX UNIQ_C9FA0CBD1BAD783F ON c_document (resource_node_id);');
        }


        if (false === $schema->hasTable('illustration')) {
            $this->addSql(
                'CREATE TABLE illustration (id INT AUTO_INCREMENT NOT NULL, resource_node_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D67B9A421BAD783F (resource_node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
            );
            $this->addSql(
                'ALTER TABLE illustration ADD CONSTRAINT FK_D67B9A421BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id) ON DELETE CASCADE;'
            );
        }
        //$this->addSql('ALTER TABLE c_document CHANGE path path VARCHAR(255) DEFAULT NULL;');

        $table = $schema->getTable('c_announcement');
        if (false === $table->hasColumn('resource_node_id')) {
            $this->addSql('ALTER TABLE c_announcement ADD resource_node_id INT DEFAULT NULL;');
            $this->addSql(
                'ALTER TABLE c_announcement ADD CONSTRAINT FK_39912E021BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id) ON DELETE CASCADE;'
            );
            $this->addSql('CREATE UNIQUE INDEX UNIQ_39912E021BAD783F ON c_announcement (resource_node_id);');
        }

        $table = $schema->getTable('c_link');
        if (false === $table->hasColumn('resource_node_id')) {
            $this->addSql('ALTER TABLE c_link ADD resource_node_id INT DEFAULT NULL;');
            $this->addSql(
                'ALTER TABLE c_link ADD CONSTRAINT FK_9209C2A01BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id) ON DELETE CASCADE;'
            );
            $this->addSql('CREATE UNIQUE INDEX UNIQ_9209C2A01BAD783F ON c_link (resource_node_id);');
        }

        $table = $schema->getTable('user');
        if (false === $table->hasColumn('resource_node_id')) {
            $this->addSql('ALTER TABLE user ADD resource_node_id INT DEFAULT NULL;');
            $this->addSql(
                'ALTER TABLE user ADD CONSTRAINT FK_8D93D6491BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id) ON DELETE CASCADE;'
            );
            $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491BAD783F ON user (resource_node_id);');
        }

        if (false === $schema->hasTable('c_shortcut')) {
            $this->addSql(
                'CREATE TABLE IF NOT EXISTS c_shortcut (id INT AUTO_INCREMENT NOT NULL, shortcut_node_id INT DEFAULT NULL, resource_node_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3F6BB957937100BE (shortcut_node_id), UNIQUE INDEX UNIQ_3F6BB9571BAD783F (resource_node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC;'
            );
            $this->addSql('ALTER TABLE c_shortcut ADD CONSTRAINT FK_3F6BB957937100BE FOREIGN KEY (shortcut_node_id) REFERENCES resource_node (id);');
            $this->addSql('ALTER TABLE c_shortcut ADD CONSTRAINT FK_3F6BB9571BAD783F FOREIGN KEY (resource_node_id) REFERENCES resource_node (id) ON DELETE CASCADE;');
        }

    }

    public function down(Schema $schema): void
    {
    }
}