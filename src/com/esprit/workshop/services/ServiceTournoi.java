package com.esprit.workshop.services;

import com.esprit.workshop.entites.Gamer;
import com.esprit.workshop.entites.Tournoi;
import com.esprit.workshop.entites.notif;
import com.esprit.workshop.utils.MyConnexion;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ServiceTournoi {
    private Connection cnx;
    public ServiceTournoi() {
        cnx = MyConnexion.getInstance().getCnx();
    }

    public int insertOne(Tournoi t, Gamer owner) throws SQLException {
        String query = "INSERT INTO `tournoi` (`ownertournoi_id`,`nb_team`, `nb_joueur_team`, `nomtournoi`, `device`, `image`, `etat`, `nb_participant`) " +
                "SELECT ?,?, ?, ?, ?, ?, 0, 0 " +
                "FROM DUAL " +
                "WHERE NOT EXISTS (SELECT 1 FROM `tournoi` WHERE `nomtournoi` = ?)";

        int rowsInserted = 0;

        try (PreparedStatement stmt = cnx.prepareStatement(query)) {
            stmt.setInt(1, owner.getId());
            stmt.setInt(2, t.getNb_team());
            stmt.setInt(3, t.getNb_joueur_team());
            stmt.setString(4, t.getNomtournoi());
            stmt.setString(5, t.getDevice());
            stmt.setString(6, t.getImage());
            stmt.setString(7, t.getNomtournoi());

            rowsInserted = stmt.executeUpdate();
        } catch (SQLException ex) {
            System.out.println("Error executing insertOne: " + ex.getMessage());
            throw ex;
        }

        return rowsInserted;
    }




    public List<Tournoi> selectAll() throws SQLException {
        List<Tournoi> temp = new ArrayList<>();

        String req = "SELECT * FROM `tournoi`";
        Statement st = cnx.createStatement();

        ResultSet rs = st.executeQuery(req);

        while (rs.next()) {
            Tournoi p = new  Tournoi();

            p.setId(rs.getInt(1));
            p.setNb_team(rs.getInt(3));
            p.setNb_joueur_team(rs.getInt(4));
            p.setNomtournoi(rs.getString("nomtournoi"));
            p.setImage(rs.getString("image"));
            p.setDevice(rs.getString("device"));

            temp.add(p);
        }
        return temp;
}
    public List<Tournoi> selectmine(Gamer owner) throws SQLException {
        List<Tournoi> temp = new ArrayList<>();

        String req = "SELECT * FROM `tournoi` WHERE `ownertournoi_id` = ?";
        PreparedStatement st = cnx.prepareStatement(req);
        st.setInt(1, owner.getId());

        ResultSet rs = st.executeQuery();

        while (rs.next()) {
            Tournoi p = new Tournoi();

            p.setId(rs.getInt(1));
            p.setNb_team(rs.getInt(3));
            p.setNb_joueur_team(rs.getInt(4));
            p.setNomtournoi(rs.getString("nomtournoi"));
            p.setImage(rs.getString("image"));
            p.setDevice(rs.getString("device"));

            temp.add(p);
        }
        return temp;
    }

    public List<Tournoi> select(String nom) throws SQLException {
        List<Tournoi> temp = new ArrayList<>();

        String req = "SELECT * FROM `tournoi` where nomtournoi ='"+nom+"'";
        Statement st = cnx.createStatement();

        ResultSet rs = st.executeQuery(req);

        while (rs.next()) {
            Tournoi p = new  Tournoi();

            p.setId(rs.getInt(1));
            p.setNb_team(rs.getInt(3));
            p.setNb_joueur_team(rs.getInt(4));
            p.setNomtournoi(rs.getString("nomtournoi"));
            p.setDevice(rs.getString("device"));
            p.setImage(rs.getString("image"));

            temp.add(p);
        }
        return temp;
}
    public int updateTournoi(Tournoi t, String nom) throws SQLException {
        String req = "UPDATE tournoi SET nb_team = ?, nb_joueur_team = ?, nomtournoi = ?, device = ?, image=? WHERE nomtournoi = ?";
        PreparedStatement pstmt = cnx.prepareStatement(req);

        pstmt.setInt(1, t.getNb_team());
        pstmt.setInt(2, t.getNb_joueur_team());
        pstmt.setString(3, t.getNomtournoi());
        pstmt.setString(4, t.getDevice());
        pstmt.setString(5, t.getImage());
        pstmt.setString(6, nom);

        int rowsUpdated = pstmt.executeUpdate();

        return rowsUpdated;
    }



    public int deleteTournoi(Tournoi t) throws SQLException {
        int rowsDeleted = 0;

        // Notify team owners of the cancelled tournament
        String notifQuery = "INSERT INTO notif (owner_id, contenet) " +
                "SELECT DISTINCT team.ownerteam_id, CONCAT('Le tournoi ', ?, ' a été annulé.') " +
                "FROM classement " +
                "INNER JOIN team ON classement.id_team_id = team.id " +
                "WHERE classement.id_tournois_id = ?";
        System.out.println(notifQuery); // Print out the SQL query
        PreparedStatement notifStatement = cnx.prepareStatement(notifQuery);
        notifStatement.setString(1, t.getNomtournoi());
        notifStatement.setInt(2, t.getId());
        int rowsInserted = notifStatement.executeUpdate();
        if (rowsInserted > 0) {
            // Delete the tournament and its associated records
            String delQuery = "DELETE t, c " +
                    "FROM tournoi t " +
                    "LEFT JOIN classement c ON t.id = c.id_tournois_id " +
                    "WHERE t.id = ?";
            PreparedStatement delStatement = cnx.prepareStatement(delQuery);
            delStatement.setInt(1, t.getId());
            rowsDeleted = delStatement.executeUpdate();
        }
        return rowsDeleted;
    }
    public void NOTIF(Gamer g, String content) throws SQLException {

        String addQuery = "INSERT INTO notif (owner_id , contenet) VALUES (?, ?)";

        PreparedStatement addStmt = cnx.prepareStatement(addQuery);
        addStmt.setInt(1, g.getId());
        addStmt.setString(2, content);
        addStmt.executeUpdate();
    }
    public int affichenbnotif(int g) throws SQLException {
        int count = 0;
        String req = "SELECT COUNT(*) FROM notif WHERE owner_id = ? ";

        PreparedStatement st = cnx.prepareStatement(req);
        st.setInt(1, g);

        ResultSet rs = st.executeQuery();

        if (rs.next()) {
            count = rs.getInt(1);

        }

        return count;
    }
    public List<notif> getNotificationsForGamer(int gamerId) throws SQLException {
        List<notif> notifications = new ArrayList<>();
        String query = "SELECT * FROM notif WHERE owner_id = ?";
        PreparedStatement statement = cnx.prepareStatement(query);
        statement.setInt(1, gamerId);
        ResultSet resultSet = statement.executeQuery();

        while (resultSet.next()) {
            notif p = new notif();

            p.setContent(resultSet.getString("contenet"));

            notifications.add(p);
        }
        return notifications;
    }

}
