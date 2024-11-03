<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241103003335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle (id UUID NOT NULL, vin VARCHAR(17) NOT NULL, make VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, year INT NOT NULL, license_plate VARCHAR(20) NOT NULL, odometer NUMERIC(10, 1) NOT NULL, status VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E486B1085141 ON vehicle (vin)');
        $this->addSql('ALTER TABLE book ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN book.id IS \'\'');
        $this->addSql('ALTER TABLE bookmark ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE bookmark ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE bookmark ALTER book_id TYPE UUID');
        $this->addSql('ALTER TABLE bookmark ALTER bookmarked_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN bookmark.id IS \'\'');
        $this->addSql('COMMENT ON COLUMN bookmark.user_id IS \'\'');
        $this->addSql('COMMENT ON COLUMN bookmark.book_id IS \'\'');
        $this->addSql('COMMENT ON COLUMN bookmark.bookmarked_at IS \'\'');
        $this->addSql('ALTER TABLE parchment ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN parchment.id IS \'\'');
        $this->addSql('ALTER TABLE review ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE review ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE review ALTER book_id TYPE UUID');
        $this->addSql('ALTER TABLE review ALTER published_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN review.id IS \'\'');
        $this->addSql('COMMENT ON COLUMN review.user_id IS \'\'');
        $this->addSql('COMMENT ON COLUMN review.book_id IS \'\'');
        $this->addSql('COMMENT ON COLUMN review.published_at IS \'\'');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('ALTER TABLE parchment ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN parchment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE book ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN book.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE review ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE review ALTER published_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE review ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE review ALTER book_id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN review.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN review.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN review.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN review.book_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE bookmark ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE bookmark ALTER bookmarked_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE bookmark ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE bookmark ALTER book_id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN bookmark.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN bookmark.bookmarked_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN bookmark.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN bookmark.book_id IS \'(DC2Type:uuid)\'');
    }
}
