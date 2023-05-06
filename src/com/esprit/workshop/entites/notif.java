package com.esprit.workshop.entites;

public class notif {
    private int id;
    private Gamer g;
    private String content;

    public notif() {
    }

    public notif(String content) {
        this.content = content;
    }

    @Override
    public String toString() {
        return "notif{" +
                "id=" + id +
                ", g=" + g +
                ", content='" + content + '\'' +
                '}';
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public Gamer getG() {
        return g;
    }

    public void setG(Gamer g) {
        this.g = g;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }
}
