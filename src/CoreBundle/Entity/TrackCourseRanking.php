<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    attributes: [
        'security' => "is_granted('ROLE_USER')",
    ],
    denormalizationContext: [
        'groups' => ['trackCourseRanking:write'],
    ],
    normalizationContext: [
        'groups' => ['trackCourseRanking:read'],
    ],
)]
#[ORM\Table(name: 'track_course_ranking')]
#[ORM\Index(name: 'idx_tcc_cid', columns: ['c_id'])]
#[ORM\Index(name: 'idx_tcc_sid', columns: ['session_id'])]
#[ORM\Index(name: 'idx_tcc_urlid', columns: ['url_id'])]
#[ORM\Index(name: 'idx_tcc_creation_date', columns: ['creation_date'])]
#[ORM\Entity]
class TrackCourseRanking
{
    #[Groups(['course:read', 'trackCourseRanking:read'])]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    protected ?int $id = null;

    #[ApiSubresource]
    #[Groups(['course:read', 'trackCourseRanking:read', 'trackCourseRanking:write'])]
    #[ORM\OneToOne(targetEntity: \Chamilo\CoreBundle\Entity\Course::class, inversedBy: 'trackCourseRanking')]
    #[ORM\JoinColumn(name: 'c_id', referencedColumnName: 'id', nullable: false, onDelete: 'cascade')]
    protected Course $course;

    #[Groups(['trackCourseRanking:read', 'trackCourseRanking:write'])]
    #[ORM\Column(name: 'session_id', type: 'integer', nullable: false)]
    protected int $sessionId;

    #[Groups(['trackCourseRanking:read', 'trackCourseRanking:write'])]
    #[ORM\Column(name: 'url_id', type: 'integer', nullable: false)]
    protected int $urlId;

    #[Groups(['course:read', 'trackCourseRanking:read'])]
    #[ORM\Column(name: 'accesses', type: 'integer', nullable: false)]
    protected int $accesses;

    #[Groups(['course:read', 'trackCourseRanking:read', 'trackCourseRanking:write'])]
    #[ORM\Column(name: 'total_score', type: 'integer', nullable: false)]
    protected int $totalScore;

    #[Groups(['course:read'])]
    #[ORM\Column(name: 'users', type: 'integer', nullable: false)]
    protected int $users;

    #[ORM\Column(name: 'creation_date', type: 'datetime', nullable: false)]
    protected DateTime $creationDate;

    #[Groups(['course:read', 'trackCourseRanking:read'])]
    protected ?int $realTotalScore = null;

    public function __construct()
    {
        $this->urlId = 0;
        $this->accesses = 0;
        $this->totalScore = 0;
        $this->users = 0;
        $this->creationDate = new DateTime();
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    /**
     * Set sessionId.
     *
     * @return TrackCourseRanking
     */
    public function setSessionId(int $sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId.
     *
     * @return int
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set urlId.
     *
     * @return TrackCourseRanking
     */
    public function setUrlId(int $urlId)
    {
        $this->urlId = $urlId;

        return $this;
    }

    /**
     * Get urlId.
     *
     * @return int
     */
    public function getUrlId()
    {
        return $this->urlId;
    }

    /**
     * Set accesses.
     *
     * @return TrackCourseRanking
     */
    public function setAccesses(int $accesses)
    {
        $this->accesses = $accesses;

        return $this;
    }

    /**
     * Get accesses.
     *
     * @return int
     */
    public function getAccesses()
    {
        return $this->accesses;
    }

    /**
     * Set totalScore.
     *
     * @return TrackCourseRanking
     */
    public function setTotalScore(int $totalScore)
    {
        $this->users++;
        $this->totalScore += $totalScore;

        return $this;
    }

    /**
     * Get totalScore.
     *
     * @return int
     */
    public function getTotalScore()
    {
        return $this->totalScore;
    }

    /**
     * Set users.
     *
     * @return TrackCourseRanking
     */
    public function setUsers(int $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users.
     *
     * @return int
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set creationDate.
     *
     * @return TrackCourseRanking
     */
    public function setCreationDate(DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getRealTotalScore(): int
    {
        if (0 !== $this->totalScore && 0 !== $this->users) {
            return (int) round($this->totalScore / $this->users);
        }

        return 0;
    }
}
