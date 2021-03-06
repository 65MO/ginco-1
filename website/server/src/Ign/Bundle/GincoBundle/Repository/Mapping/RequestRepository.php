<?php
namespace Ign\Bundle\GincoBundle\Repository\Mapping;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Ign\Bundle\OGAMBundle\Entity\Metadata\TableFormat;
use Ign\Bundle\OGAMBundle\Entity\Metadata\TableField;
use Doctrine\DBAL\Schema\Schema;

/**
 * RequestRepository
 */
class RequestRepository extends \Doctrine\ORM\EntityRepository {

	/**
	 * Create a request.
	 *
	 * @param String $session_id
	 *        	the session id
	 * @return integer the id of the request inserted
	 */
	function createRequest($sessionId) {
		$em = $this->getEntityManager();

		$sql = "INSERT INTO requests (session_id) VALUES ('$sessionId') RETURNING id;";

		$reqId = $em->getConnection()->fetchColumn($sql, array(), 0);
		return $reqId;
	}

	/**
	 * Gets the id of the last request played within the current session.
	 * MIGRATED
	 *
	 * @param
	 *        	Integer the session id
	 * @return String the request id
	 */
	public function getLastRequestIdFromSession($sessionId) {
		$conn = $this->_em->getConnection();

		$sql = "SELECT id FROM requests req WHERE req.session_id = ?
				ORDER BY req.id DESC LIMIT 1";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $sessionId);
		$stmt->execute(array(
			$sessionId
		));

		return $stmt->fetchColumn();
	}

	/**
	 * Returns the bounding box that bounds geometries of results table.
	 *
	 * @param
	 *        	String the user session id.
	 * @param
	 *        	String the srs_visualisation
	 * @return String the bounging box as WKT (well known text)
	 */
	public function getResultsBBox($sessionId, $projection) {
		$conn = $this->_em->getConnection();
		$sql = "SELECT st_astext(st_extent(st_transform(the_geom," . $projection . "))) as wkt FROM result_location WHERE session_id = :session_id";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue("session_id", $sessionId);
		$stmt->execute();
		$bbox = $stmt->fetchColumn();
		if ($bbox !== FALSE && $bbox !== "") {
			return $bbox;
		} else {
			throw new NoResultException('No result location found for the current session.');
		}
	}

}
