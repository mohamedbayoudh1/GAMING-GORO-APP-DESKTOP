package com.esprit.workshop.services;

import com.esprit.workshop.entites.Gamer;
import com.esprit.workshop.entites.Team;
import com.esprit.workshop.entites.Tournoi;
import com.esprit.workshop.utils.MyConnexion;
import javafx.scene.control.Alert;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ServiceTeam {
    private Connection cnx;
    public ServiceTeam() {
        cnx = MyConnexion.getInstance().getCnx();
    }

    public int insertOneteam(Team t, Gamer owner) throws SQLException {
        String query = "INSERT INTO `team` (`nom_team`,`nb_joueurs`, `about`, `logo`,`ownerteam_id`) " +
                "SELECT ?, ?, ?, ?, ? " +
                "FROM DUAL " +
                "WHERE NOT EXISTS (SELECT 1 FROM `team` WHERE `nom_team` = ?)";

        try (PreparedStatement stmt = cnx.prepareStatement(query)) {
            stmt.setString(1, t.getNom_team());
            stmt.setInt(2, t.getNb_joueurs());
            stmt.setString(3, t.getAbout());
            stmt.setString(4, t.getLogo());
            stmt.setInt(5, owner.getId());
            stmt.setString(6, t.getNom_team());
            int rowsInserted = stmt.executeUpdate();
            return rowsInserted;

        }
        catch (SQLException ex) {
            System.out.println("Error executing insertOne: " + ex.getMessage());
            throw ex;
        }
    }



    public List<Team> selectAllteam() throws SQLException {
        List<Team> temp = new ArrayList<>();

        String req = "SELECT * FROM `team`";
        Statement st = cnx.createStatement();

        ResultSet rs = st.executeQuery(req);

        while (rs.next()) {
            Team p = new Team();

            p.setId(rs.getInt(1));
            p.setNb_joueurs(rs.getInt(4));
            p.setNom_team(rs.getString("nom_team"));
            p.setLogo(rs.getString("logo"));
            p.setAbout(rs.getString("about"));
            p.setWin(rs.getInt("win"));
            p.setLose(rs.getInt("lose"));


            temp.add(p);
        }
        return temp;
}
    public List<Team> selectoneteam(Gamer owner) throws SQLException {
        List<Team> temp = new ArrayList<>();

        String req = "SELECT * FROM `team` WHERE `ownerteam_id` = ?";
        PreparedStatement st = cnx.prepareStatement(req);
        st.setInt(1, owner.getId());


        ResultSet rs = st.executeQuery();

        while (rs.next()) {
            Team p = new Team();

            p.setId(rs.getInt(1));
            p.setNb_joueurs(rs.getInt(4));
            p.setNom_team(rs.getString("nom_team"));
            p.setLogo(rs.getString("logo"));
            p.setAbout(rs.getString("about"));
            p.setWin(rs.getInt("win"));
            p.setLose(rs.getInt("lose"));


            temp.add(p);
        }
        return temp;
    }
public List<Team> selecttea(String nom) throws SQLException {
        List<Team> temp = new ArrayList<>();

        String req = "SELECT * FROM `team` where nom_team ='"+nom+"'";
        Statement st = cnx.createStatement();

        ResultSet rs = st.executeQuery(req);

        while (rs.next()) {
            Team p = new  Team();

            p.setId(rs.getInt(1));
        /*    p.setNb_team(rs.getInt(3));
            p.setNb_joueur_team(rs.getInt(4));
            p.setNomtournoi(rs.getString("nomtournoi"));
            p.setDevice(rs.getString("device"));
            p.setImage(rs.getString("image"));
*/
            temp.add(p);
        }
        return temp;
}
    public void updateteam(Team t, String nom) throws SQLException {
        String req = "UPDATE team SET nom_team = ?, nb_joueurs = ?, about = ?, logo = ? WHERE nom_team = ?";
        PreparedStatement pstmt = cnx.prepareStatement(req);

        pstmt.setString(1, t.getNom_team());
        pstmt.setInt(2, t.getNb_joueurs());
        pstmt.setString(3, t.getAbout());
        pstmt.setString(4, t.getLogo());
        pstmt.setString(5, nom);

        int rowsUpdated = pstmt.executeUpdate();

        if (rowsUpdated > 0) {
            Alert alert = new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Succès");
            alert.setHeaderText("Team modifié");
            alert.setContentText("Le team a été modifié avec succès !");
            alert.showAndWait();
        } else {
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("Attention");
            alert.setHeaderText("Aucun team modifié");
            alert.setContentText("Aucun team n'a été modifié !");
            alert.showAndWait();
        }
    }



    public void deleteTeam(String nom) throws SQLException {
        String req = "DELETE FROM team WHERE nom_team = ?";
        PreparedStatement pstmt = cnx.prepareStatement(req);
        pstmt.setString(1, nom);

        int rowsDeleted = pstmt.executeUpdate();

        if (rowsDeleted > 0) {
            Alert alert = new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Succès");
            alert.setHeaderText("team supprimé");
            alert.setContentText("Le team a été supprimé avec succès !");
            alert.showAndWait();
        } else {
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("Attention");
            alert.setHeaderText("Aucun team supprimé");
            alert.setContentText("Aucun team n'a été supprimé !");
            alert.showAndWait();
        }
    }


}
