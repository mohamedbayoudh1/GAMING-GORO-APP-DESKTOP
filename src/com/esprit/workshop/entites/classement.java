package com.esprit.workshop.entites;

import java.util.List;

public class classement {
    private int id;
    private Tournoi tournoi;
    private Team team;
    private int score;

    public classement() {}

    public classement(int id, Tournoi tournoi, Team team, int score) {
        this.id = id;
        this.tournoi = tournoi;
        this.team = team;
        this.score = score;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public Tournoi getTournoi() {
        return tournoi;
    }

    public void setTournoi(Tournoi tournoi) {
        this.tournoi = tournoi;
    }

    public Team getTeam() {
        return team;
    }

    public void setTeam(Team team) {
        this.team = team;
    }

    public int getScore() {
        return score;
    }

    public void setScore(int score) {
        this.score = score;
    }

    @Override
    public String toString() {
        return "classement{" +
                "id=" + id +
                ", tournoi=" + tournoi +
                ", team=" + team +
                ", score=" + score +
                '}';
    }

}
