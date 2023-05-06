package com.esprit.workshop.entites;

import java.sql.Timestamp;

public class Tournoi {
    private int id;
    private int nb_team	;
    private int nb_joueur_team;
    private String nomtournoi;
    private String device;
    private Timestamp dateHeure;
    private String image;
    private int etat;
    private int nb_participant;
    private Gamer owner;

    public Gamer getOwner() {
        return owner;
    }

    public void setOwner(Gamer owner) {
        this.owner = owner;
    }

    public Tournoi() {
    }

    public Tournoi(int nb_team, int nb_joueur_team, String nomtournoi, String device) {
        this.nb_team = nb_team;
        this.nb_joueur_team = nb_joueur_team;
        this.nomtournoi = nomtournoi;
        this.device = device;
    }

    public Tournoi(int nb_team, int nb_joueur_team, String nomtournoi, String device,String image) {
        this.nb_team = nb_team;
        this.nb_joueur_team = nb_joueur_team;
        this.nomtournoi = nomtournoi;
        this.device = device;
        this.image = image;
    }

    public Tournoi(int id_tournoi) {
    }

    public int getId() {
        return id;
    }

    public int getNb_team() {
        return nb_team;
    }

    public int getNb_joueur_team() {
        return nb_joueur_team;
    }

    public String getNomtournoi() {
        return nomtournoi;
    }

    public String getDevice() {
        return device;
    }

    public Timestamp getDateHeure() {
        return dateHeure;
    }

    public String getImage() {
        return image;
    }

    public int getEtat() {
        return etat;
    }

    public int getNb_participant() {
        return nb_participant;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setNb_team(int nb_team) {
        this.nb_team = nb_team;
    }

    public void setNb_joueur_team(int nb_joueur_team) {
        this.nb_joueur_team = nb_joueur_team;
    }

    public void setNomtournoi(String nomtournoi) {
        this.nomtournoi = nomtournoi;
    }

    public void setDevice(String device) {
        this.device = device;
    }

    public void setDateHeure(Timestamp dateHeure) {
        this.dateHeure = dateHeure;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public void setEtat(int etat) {
        this.etat = etat;
    }

    public void setNb_participant(int nb_participant) {
        this.nb_participant = nb_participant;
    }

    @Override
    public String toString() {
        return "Tournoi{" +
                "id=" + id +
                ", nb_team=" + nb_team +
                ", nb_joueur_team=" + nb_joueur_team +
                ", nomtournoi='" + nomtournoi + '\'' +
                ", device='" + device + '\'' +
                ", dateHeure=" + dateHeure +
                ", image='" + image + '\'' +
                ", etat=" + etat +
                ", nb_participant=" + nb_participant +
                '}';
    }


}
