package at.bluephoenix.javaranz;

import at.bluephoenix.dummylib.BinaryAdder;

public class Main {

    public static void main(String[] args) {
        System.out.println(HelloWorld.hello());

        BinaryAdder adder = new BinaryAdder(2, 3);
        System.out.format("2 + 3 = %d\n", adder.add());
    }

}
