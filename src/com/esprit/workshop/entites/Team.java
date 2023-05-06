package com.esprit.workshop.entites;

public class Team {
    private int id;
    private int ownerteam_id;
    private String nom_team;
    private int nb_joueurs;
    private String about;
    private String logo;
    private int win;
    private int lose;
    private Gamer owner;

    public Gamer getOwner() {
        return owner;
    }

    public void setOwner(Gamer owner) {
        this.owner = owner;
    }

    public Team() {

    }

    public Team(String nom_team, int nb_joueurs, String about, String logo) {
        this.nom_team = nom_team;
        this.nb_joueurs = nb_joueurs;
        this.about = about;
        this.logo = logo;
    }

    public Team(int id_team, String nomteam) {

            this.id = id_team;
            this.nom_team = nomteam;


    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getOwnerteam_id() {
        return ownerteam_id;
    }

    public void setOwnerteam_id(int ownerteam_id) {
        this.ownerteam_id = ownerteam_id;
    }

    public String getNom_team() {
        return nom_team;
    }

    public void setNom_team(String nom_team) {
        this.nom_team = nom_team;
    }

    public int getNb_joueurs() {
        return nb_joueurs;
    }

    public void setNb_joueurs(int nb_joueurs) {
        this.nb_joueurs = nb_joueurs;
    }

    public String getAbout() {
        return about;
    }

    public void setAbout(String about) {
        this.about = about;
    }

    public String getLogo() {
        return logo;
    }

    public void setLogo(String logo) {
        this.logo = logo;
    }

    public int getWin() {
        return win;
    }

    public void setWin(int win) {
        this.win = win;
    }

    public int getLose() {
        return lose;
    }

    public void setLose(int lose) {
        this.lose = lose;
    }

    @Override
    public String toString() {
        return "Team{" +
                "id=" + id +
                ", ownerteam_id=" + ownerteam_id +
                ", nom_team='" + nom_team + '\'' +
                ", nb_joueurs=" + nb_joueurs +
                ", about='" + about + '\'' +
                ", logo='" + logo + '\'' +
                ", win=" + win +
                ", lose=" + lose +
                '}';
    }
}
