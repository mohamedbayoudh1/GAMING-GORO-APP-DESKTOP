package com.esprit.workshop.services;
import com.esprit.workshop.entites.classement;

import com.esprit.workshop.entites.Team;
import com.esprit.workshop.entites.Tournoi;
import com.esprit.workshop.utils.MyConnexion;
import javafx.scene.control.Alert;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

public class serviceclassement {
    private Connection cnx;
    private PreparedStatement ps;

    public serviceclassement() {
        cnx = MyConnexion.getInstance().getCnx();
    }
    public void addClassement(Tournoi idTournoi, Team idTeam) throws SQLException {
        String req = "INSERT INTO classement (id_tournois_id, id_team_id) VALUES (?, ?)";
        ps = cnx.prepareStatement(req);
        ps.setInt(1, idTournoi.getId());
        ps.setInt(2, idTeam.getId());
        ps.executeUpdate();
        System.out.println("Classement ajouté avec succès !");
    }
    public List<classement> selectAll(int tournoiId) throws SQLException {
        List<classement> temp = new ArrayList<>();

        String req = "SELECT classement.*, team.nom_team FROM classement JOIN team ON classement.id_team_id = team.id WHERE classement.id_tournois_id = ?";
        PreparedStatement ps = cnx.prepareStatement(req);
        ps.setInt(1, tournoiId);

        ResultSet rs = ps.executeQuery();

        while (rs.next()) {
            classement p = new classement();

            p.setId(rs.getInt("id"));
            p.setTournoi(new Tournoi(rs.getInt("id_tournois_id")));
            p.setTeam(new Team(rs.getInt("id_team_id"), rs.getString("nom_team")));
            p.setScore(rs.getInt("score"));
            temp.add(p);
        }
        return temp;
    }

}
